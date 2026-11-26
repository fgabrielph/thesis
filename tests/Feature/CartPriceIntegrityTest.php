<?php

namespace Tests\Feature;

use App\Item;
use App\Order;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartPriceIntegrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_uses_item_price_not_request_price(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 1)->firstOrFail();

        $this->post(route('cart.store'), [
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => 1,
            'price' => 1,
        ]);

        $this->assertSame(number_format($item->price_stocks, 2), Cart::total());
    }

    public function test_checkout_rejects_a_cart_item_whose_price_changed(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 1)->firstOrFail();
        $this->addToCart($item);

        $item->forceFill(['price_stocks' => $item->price_stocks + 100])->save();

        $ordersBefore = Order::count();
        $user = $this->verifiedUser();

        $this->actingAs($user)
            ->post(route('checkout.store'), $this->checkoutPayload())
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertSame($ordersBefore, Order::count());
    }

    public function test_checkout_rejects_a_cart_item_whose_stock_is_too_low(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 1)->firstOrFail();
        $this->addToCart($item);

        $item->forceFill(['stocks' => 0])->save();

        $ordersBefore = Order::count();
        $user = $this->verifiedUser();

        $this->actingAs($user)
            ->post(route('checkout.store'), $this->checkoutPayload())
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertSame($ordersBefore, Order::count());
    }

    private function addToCart(Item $item): void
    {
        $this->post(route('cart.store'), [
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => 1,
            'price' => $item->price_stocks,
        ]);
    }

    private function verifiedUser(): User
    {
        $user = User::create([
            'first_name' => 'Price',
            'last_name' => 'Customer',
            'email' => 'price-integrity@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        return $user;
    }

    /**
     * @return array<string, string>
     */
    private function checkoutPayload(): array
    {
        return [
            'firstName' => 'Price',
            'lastName' => 'Customer',
            'city' => 'Manila',
            'address' => '1 Test Street',
            'zip' => '1000',
            'mobile_num' => '09171234567',
            'paymentMethod' => 'cod',
        ];
    }
}
