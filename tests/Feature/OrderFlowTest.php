<?php

namespace Tests\Feature;

use App\Admin;
use App\Delivery;
use App\Item;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_accepting_an_order_deducts_stock_only_once(): void
    {
        $this->seed();

        $order = Order::where('status', 'Pending')->firstOrFail();
        $suborder = $order->suborder()->firstOrFail();
        $item = Item::findOrFail($suborder->item_id);
        $before = $item->stocks;

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->post(route('admin_orders.status', ['status' => 'Accept', 'id' => $order->id]))
            ->assertRedirect();

        $this->assertSame($before - $suborder->quantity, $item->fresh()->stocks);
        $this->assertNotNull($order->fresh()->stock_deducted_at);

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->post(route('admin_orders.status', ['status' => 'Accept', 'id' => $order->id]))
            ->assertRedirect();

        $this->assertSame($before - $suborder->quantity, $item->fresh()->stocks);
    }

    public function test_cod_delivery_completion_does_not_deduct_stock_twice(): void
    {
        $this->seed();

        $order = Order::where('status', 'Pending')->firstOrFail();
        $suborder = $order->suborder()->firstOrFail();
        $item = Item::findOrFail($suborder->item_id);

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->post(route('admin_orders.status', ['status' => 'Accept', 'id' => $order->id]))
            ->assertRedirect();

        $afterAccept = $item->fresh()->stocks;

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->post(route('deliveries.eda', $order->id), ['date' => now()->addDay()->format('M d, Y')])
            ->assertRedirect();

        $delivery = Delivery::where('order_id', $order->id)->firstOrFail();

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->post(route('deliveries.status', ['status' => 'Completed', 'id' => $delivery->id]))
            ->assertRedirect();

        $this->assertSame($afterAccept, $item->fresh()->stocks);
        $this->assertNotNull($order->fresh()->stock_deducted_at);
    }

    public function test_eda_does_not_create_duplicate_deliveries(): void
    {
        $this->seed();

        $order = Order::where('status', 'Confirmed')
            ->whereDoesntHave('delivery')
            ->firstOrFail();

        $payload = ['date' => now()->addDay()->format('M d, Y')];

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->post(route('deliveries.eda', $order->id), $payload)
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->post(route('deliveries.eda', $order->id), $payload)
            ->assertRedirect();

        $this->assertSame(1, Delivery::where('order_id', $order->id)->count());
        $this->assertSame('On Delivery', $order->fresh()->status);
    }

    public function test_customer_cannot_cancel_a_completed_order(): void
    {
        $this->seed();

        $order = Order::where('status', 'Completed')->firstOrFail();
        $user = User::findOrFail($order->user_id);

        $this->actingAs($user)
            ->put(route('orders.update', $order->id))
            ->assertRedirect();

        $this->assertSame('Completed', $order->fresh()->status);
    }

    public function test_delivery_cannot_move_backward_from_completed(): void
    {
        $this->seed();

        $order = Order::where('status', 'Completed')->firstOrFail();
        $delivery = Delivery::firstOrCreate(
            ['order_id' => $order->id],
            ['status' => 'Completed', 'customer_name' => 'Test User']
        );

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->post(route('deliveries.status', ['status' => 'On Delivery', 'id' => $delivery->id]))
            ->assertRedirect();

        $this->assertSame('Completed', $delivery->fresh()->status);
    }
}
