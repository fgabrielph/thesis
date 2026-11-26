<?php

namespace Tests\Feature;

use App\Item;
use App\Order;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTaxTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_total_matches_item_subtotal(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 0)->firstOrFail();
        $quantity = 2;

        $this->addToCart($item, $quantity);

        $this->assertSame(0, config('cart.tax'));
        $this->assertSame(
            number_format($item->price_stocks * $quantity, 2),
            Cart::total()
        );

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('₱'.number_format($item->price_stocks * $quantity, 2));
    }

    public function test_checkout_stores_grand_total_without_tax(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 0)->firstOrFail();
        $quantity = 2;

        $this->addToCart($item, $quantity);

        $user = User::create([
            'first_name' => 'Tax',
            'last_name' => 'Customer',
            'email' => 'cart-tax@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $this->actingAs($user)
            ->post(route('checkout.store'), [
                'firstName' => 'Tax',
                'lastName' => 'Customer',
                'city' => 'Manila',
                'address' => '1 Test Street',
                'zip' => '1000',
                'mobile_num' => '09171234567',
                'paymentMethod' => 'cod',
            ])
            ->assertRedirect();

        $order = Order::where('user_id', $user->id)->latest('id')->firstOrFail();

        $this->assertEquals($item->price_stocks * $quantity, $order->grand_total);
    }

    private function addToCart(Item $item, int $quantity): void
    {
        $this->post(route('cart.store'), [
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => $quantity,
            'price' => $item->price_stocks,
        ]);
    }
}
