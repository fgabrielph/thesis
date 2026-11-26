<?php

namespace Tests\Feature;

use App\CustomOrder;
use App\Invoice;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_cannot_view_or_cancel_another_customers_order(): void
    {
        $owner = $this->makeUser('owner@example.com');
        $intruder = $this->makeUser('intruder@example.com');
        $order = $this->makeOrder($owner);

        $this->actingAs($owner)
            ->get(route('orders.show', $order->id))
            ->assertOk();

        $this->actingAs($intruder)
            ->get(route('orders.show', $order->id))
            ->assertNotFound();

        $this->actingAs($intruder)
            ->put(route('orders.update', $order->id))
            ->assertNotFound();
    }

    public function test_customers_cannot_view_another_customers_invoice(): void
    {
        $owner = $this->makeUser('invoice-owner@example.com');
        $intruder = $this->makeUser('invoice-intruder@example.com');
        $order = $this->makeOrder($owner);

        $this->actingAs($owner)
            ->get(route('invoice.show', $order->invoice_id))
            ->assertOk();

        $this->actingAs($intruder)
            ->get(route('invoice.show', $order->invoice_id))
            ->assertNotFound();
    }

    public function test_customers_cannot_view_or_pay_another_customers_custom_order(): void
    {
        $owner = $this->makeUser('custom-owner@example.com');
        $intruder = $this->makeUser('custom-intruder@example.com');
        $customOrder = $this->makeCustomOrder($owner);

        $this->actingAs($owner)
            ->get(route('custom_order.show', $customOrder->id))
            ->assertOk();

        $this->actingAs($intruder)
            ->get(route('custom_order.show', $customOrder->id))
            ->assertNotFound();

        $this->actingAs($intruder)
            ->put(route('custom_order.payment', $customOrder->id), ['payment_method' => 'cod'])
            ->assertNotFound();
    }

    public function test_customers_cannot_upload_proof_to_another_customers_order(): void
    {
        $owner = $this->makeUser('proof-owner@example.com');
        $intruder = $this->makeUser('proof-intruder@example.com');
        $order = $this->makeOrder($owner);

        $this->actingAs($owner)
            ->get(route('proof.add', $order->id))
            ->assertOk();

        $this->actingAs($intruder)
            ->get(route('proof.add', $order->id))
            ->assertNotFound();

        $this->actingAs($intruder)
            ->put(route('proof.upload', $order->id), ['image' => UploadedFile::fake()->image('proof.jpg')])
            ->assertNotFound();
    }

    private function makeUser(string $email): User
    {
        return User::forceCreate([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => $email,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);
    }

    private function makeOrder(User $user): Order
    {
        $invoice = Invoice::forceCreate([
            'price' => 100,
            'currency' => 'PHP',
            'payment_status' => 'PENDING',
        ]);

        return Order::forceCreate([
            'order_number' => 'ORD-TEST-'.uniqid(),
            'status' => 'Pending',
            'user_id' => $user->id,
            'invoice_id' => $invoice->id,
            'grand_total' => 100,
            'item_count' => 1,
            'payment_status' => 0,
            'payment_method' => 'cod',
            'first_name' => 'Test',
            'last_name' => 'User',
            'address' => 'Test address',
            'city' => 'Manila',
            'zip_code' => '1000',
            'phone_number' => '09171234567',
        ]);
    }

    private function makeCustomOrder(User $user): CustomOrder
    {
        return CustomOrder::forceCreate([
            'user_id' => $user->id,
            'name' => 'Test custom order',
            'status' => 0,
            'payment_status' => 2,
            'payment_method' => 'cod',
            'quantity' => 1,
            'price' => 100,
            'address' => 'Test address',
            'city' => 'Manila',
            'zip_code' => '1000',
        ]);
    }
}
