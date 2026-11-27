<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_uses_the_storefront_shell(): void
    {
        $this->seed();
        $user = User::where('email', 'customer@example.com')->firstOrFail();

        $this->actingAs($user)
            ->get(route('account.index'))
            ->assertOk()
            ->assertSee('data-storefront', false)
            ->assertSee('account-nav', false);
    }

    public function test_orders_list_detail_and_invoice_use_the_storefront_shell(): void
    {
        $this->seed();
        $user = User::where('email', 'customer@example.com')->firstOrFail();
        $order = $user->orders()->firstOrFail();

        $this->actingAs($user)->get(route('orders.index'))
            ->assertOk()
            ->assertSee('data-storefront', false)
            ->assertSee('sf-orders', false);

        $this->actingAs($user)->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee('sf-order-detail', false);

        $this->actingAs($user)->get(route('invoice.show', $order->invoice_id))
            ->assertOk()
            ->assertSee('sf-invoice', false);
    }
}
