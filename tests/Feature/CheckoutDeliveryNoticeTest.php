<?php

namespace Tests\Feature;

use App\Item;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutDeliveryNoticeTest extends TestCase
{
    use RefreshDatabase;

    public function test_delivery_notice_is_shown_in_cart_and_checkout(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 0)->firstOrFail();

        $this->post(route('cart.store'), [
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => 1,
            'price' => $item->price_stocks,
        ]);

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('data-storefront', false)
            ->assertSee('sf-order-summary', false)
            ->assertSee('Free delivery within metro manila');

        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'Customer',
            'email' => 'delivery-notice@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $this->actingAs($user)
            ->get(route('checkout.index'))
            ->assertOk()
            ->assertSee('Free delivery within metro manila');
    }
}
