<?php

namespace Tests\Feature;

use App\Item;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_redirects_to_an_order_confirmation_page(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 0)->firstOrFail();

        $this->post(route('cart.store'), [
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => 1,
            'price' => $item->price_stocks,
        ]);

        $user = $this->verifiedUser('buyer');

        $response = $this->actingAs($user)->post(route('checkout.store'), $this->checkoutPayload());

        $order = Order::where('user_id', $user->id)->latest('id')->firstOrFail();

        $response->assertRedirect(route('checkout.confirmation', $order));

        $this->actingAs($user)
            ->get(route('checkout.confirmation', $order))
            ->assertOk()
            ->assertSee($order->order_number);
    }

    public function test_another_customer_cannot_view_the_confirmation(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 0)->firstOrFail();

        $this->post(route('cart.store'), [
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => 1,
            'price' => $item->price_stocks,
        ]);

        $buyer = $this->verifiedUser('buyer');
        $this->actingAs($buyer)->post(route('checkout.store'), $this->checkoutPayload());

        $order = Order::where('user_id', $buyer->id)->latest('id')->firstOrFail();
        $other = $this->verifiedUser('other');

        $this->actingAs($other)
            ->get(route('checkout.confirmation', $order))
            ->assertNotFound();
    }

    private function verifiedUser(string $name): User
    {
        $user = User::create([
            'first_name' => $name,
            'last_name' => 'Customer',
            'email' => $name.'-confirmation@example.com',
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
            'firstName' => 'Buyer',
            'lastName' => 'Customer',
            'city' => 'Manila',
            'address' => '1 Test Street',
            'zip' => '1000',
            'mobile_num' => '09171234567',
            'paymentMethod' => 'cod',
        ];
    }
}
