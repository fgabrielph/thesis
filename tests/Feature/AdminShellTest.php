<?php

namespace Tests\Feature;

use App\Admin;
use App\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminShellTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_uses_the_admin_shell(): void
    {
        $this->seed();

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('data-admin-shell', false)
            ->assertSee('stat-card', false)
            ->assertSee('page-header', false);
    }

    public function test_admin_orders_uses_shared_components(): void
    {
        $this->seed();

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->get(route('admin_orders.index'))
            ->assertOk()
            ->assertSee('status-badge', false)
            ->assertSee('table-shell', false);
    }

    public function test_admin_items_uses_shared_table_shell(): void
    {
        $this->seed();

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->get(route('items.index'))
            ->assertOk()
            ->assertSee('table-shell', false)
            ->assertDontSee('₱ ₱', false);
    }

    public function test_staff_dashboard_uses_the_staff_shell(): void
    {
        $this->seed();

        $this->actingAs(Staff::firstOrFail(), 'staff')
            ->get(route('staff.dashboard'))
            ->assertOk()
            ->assertSee('data-staff-shell', false);
    }
}
