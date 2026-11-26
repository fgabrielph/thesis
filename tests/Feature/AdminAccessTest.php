<?php

namespace Tests\Feature;

use App\Admin;
use App\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_renders(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_staff_login_page_renders(): void
    {
        $this->get('/staff/login')->assertOk();
    }

    public function test_admin_dashboard_renders_with_vite_assets(): void
    {
        $this->seed();

        $this->actingAs(Admin::firstOrFail(), 'admin')
            ->get('/admin')
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_staff_dashboard_renders_with_vite_assets(): void
    {
        $this->seed();

        $this->actingAs(Staff::firstOrFail(), 'staff')
            ->get('/staff')
            ->assertOk()
            ->assertSee('Dashboard');
    }
}
