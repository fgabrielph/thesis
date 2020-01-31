<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\WebProfile;
use PayPal\Api\ItemList;
use PayPal\Api\InputFields;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use App\Invoice;
use App\Suborder;
use Str;
use Config;
use Request;
use Illuminate\Http\Request as Requesting;
use Illuminate\Support\Facades\Auth;
use App\Order;
use Cart;

# We call the Item Model as Product because duplicate name Entry is not allowed as we already call the Paypal API Item
use App\Item as Product;

class CheckoutController extends Controller {

    private $apiContext;

    public function __construct()
    {
        # Main configuration in constructor
        $paypalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret'])
        );

        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    public function index() {

        if(count(Cart::content()) == 0) {
            return redirect(route('cart.index'))->with('error','You need to add something on Cart');
        }

        return view('site.pages.checkout');
    }

    public function payWithpaypal(Requesting $request) {

        $this->validate($request, [
            'firstName' => 'required|max:160',
            'lastName' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required|numeric',
            'mobile_num' => 'required|numeric|digits:11',
        ]);

        # Removing Commas in thousands for Grand Total
        $string_grand_total = Cart::total();
        $formatted_grand_total = str_replace(',', '', $string_grand_total);

        # Removing Commas in thousands for Sub Total
        $string_sub_total = Cart::subtotal();
        $formatted_sub_total = str_replace(',', '', $string_sub_total);

        if($request->paymentMethod == 'cod') {
            $this->cashondelivery($request);
        }

        # We initialize the payer object and set the payment method to PayPal
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        # We insert a new order in the order table with the 'initialised' status
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->order_number = 'ORD-'.strtoupper(uniqid());
        $order->first_name = $request->firstName;
        $order->last_name = $request->lastName;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->zip_code = $request->zip;
        $order->phone_number = $request->mobile_num;
        $order->notes = $request->notes;
        $order->payment_method = $request->paymentMethod;
        $order->payment_status = 0;
        $order->item_count = Cart::count();
        $order->grand_total = $formatted_grand_total;
        $order->invoice_id = null;
        $order->status = 'Initialised';
        $order->save();

        # We need to update the order if the payment is complete, so we save it to the session
        Session::put('orderId', $order->getKey());

        # We get all the items from the cart and parse the array into the Item object
        $items = [];

        foreach (Cart::content() as $item) {
            $items[] = (new Item())
                ->setName($item->name)
                ->setCurrency('PHP')
                ->setQuantity($item->qty)
                ->setPrice($item->price);
        }

        # We create a new item list and assign the items to it
        $itemList = new ItemList();
        $itemList->setItems($items);

        # Disable all irrelevant PayPal aspects in payment
        $inputFields = new InputFields();
        $inputFields->setAllowNote(true)
            ->setNoShipping(1)
            ->setAddressOverride(0);

        $webProfile = new WebProfile();
        $webProfile->setName(uniqid())
            ->setInputFields($inputFields)
            ->setTemporary(true);

        $createProfile = $webProfile->create($this->apiContext);

        # We get the total price of the cart
        $amount = new Amount();
        $amount->setCurrency('PHP')
            ->setTotal($formatted_sub_total);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setItemList($itemList)
            ->setDescription('Pay using with Paypal');

        $redirectURLs = new RedirectUrls();
        $redirectURLs->setReturnUrl(URL::to('status'))
            ->setCancelUrl(URL::to('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectURLs)
            ->setTransactions(array($transaction));
        $payment->setExperienceProfileId($createProfile->getId());
        $payment->create($this->apiContext);

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirectURL = $link->getHref();
                break;
            }
        }

        # We store the payment ID into the session
        Session::put('paypalPaymentId', $payment->getId());

        if (isset($redirectURL)) {
            return Redirect::away($redirectURL);
        }

        return Redirect::to('/cart')->with('error', 'There was a problem processing your payment. Please contact support.');
    }

    public function getPaymentStatus()
    {
        $paymentId = Session::get('paypalPaymentId');
        $orderId = Session::get('orderId');

        # We now erase the payment ID from the session to avoid fraud
        # I Disabled it first for the refresh page works
        # Session::forget('paypalPaymentId');

        # If the payer ID or token isn't set, there was a corrupt response and instantly abort
        if (empty(Request::get('PayerID')) || empty(Request::get('token'))) {

            return Redirect::to('/cart')->with('error', 'There was a problem processing your payment. Please contact support.');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId(Request::get('PayerID'));

        $result = $payment->execute($execution, $this->apiContext);

        # Payment is processing but may still fail due e.g to insufficient funds
        $order = Order::find($orderId);
        $order->status = 'Processing';

        if ($result->getState() == 'approved') {

            $invoice = new Invoice();
            $invoice->price = $result->transactions[0]->getAmount()->getTotal();
            $invoice->currency = $result->transactions[0]->getAmount()->getCurrency();
            $invoice->customer_email = $result->getPayer()->getPayerInfo()->getEmail();
            $invoice->customer_id = $result->getPayer()->getPayerInfo()->getPayerId();
            $invoice->country_code = $result->getPayer()->getPayerInfo()->getCountryCode();
            $invoice->payment_id = $result->getId();

            # We update the invoice status
            $invoice->payment_status = 'approved';
            $invoice->save();

            # We also update the order status
            $order->invoice_id = $invoice->getKey();
            $order->status = 'Pending';
            $order->payment_status = 1;
            $order->save();

            # We insert the suborder (products) into the table
            foreach (Cart::content() as $item) {
                $suborder = new Suborder();
                $suborder->order_id = $orderId;
                $suborder->item_id = $item->id;
                $suborder->price = $item->price;
                $suborder->quantity = $item->qty;
                $suborder->save();

                # We Decrease the stocks based on sub orders
                Product::where('id', $suborder->item_id)->decrement('stocks', $suborder->quantity);
            }

            Cart::destroy();

            return Redirect::to('/cart')->with('success', 'Your payment was successful. Thank you.');
        }



        return Redirect::to('/cart')->with('error', 'There was a problem processing your payment. Please contact support.');
    }

    public function cashondelivery($request) {

        //Validation
        $this->validate($request, [
            'firstName' => 'required|max:160',
            'lastName' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required|numeric',
            'mobile_num' => 'required|numeric|digits:11',
        ]);

        dd($request->all());

//        $order = new Order;
//        $order->order_number = 'ORD-'.strtoupper(uniqid());
//        $order->user_id = auth()->user()->id;
//        $order->first_name = $request->firstName;
//        $order->last_name = $request->lastName;
//        $order->address = $request->address;
//        $order->city = $request->city;
//        $order->zip_code = $request->zip;
//        $order->phone_number = $request->mobile_num;
//        $order->notes = $request->notes;
//        $order->payment_method = $request->paymentMethod;
//        $order->payment_status = 0;
//        $order->item_count = Cart::count();
//        $order->grand_total = Cart::total();
//        $order->status = 0;
//        $order->save();

//        if($request->paymentMethod == 'paypal') {
//
//
//        }
        # This will get the latest order of the logged user

        //$orders = Order::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->first();
        //$orders->payment_status = 1;
        //$orders->status = 1;
        //$orders->save();

        return 'Cash on Delivery';

    }


}
