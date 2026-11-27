<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_pages_use_the_storefront_shell(): void
    {
        foreach (['login', 'register', 'password.request'] as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee('data-storefront', false)
                ->assertDontSee('jquery', false)
                ->assertDontSee('mdb', false);
        }
    }

    public function test_password_reset_and_verification_use_the_storefront_shell(): void
    {
        $this->get(route('password.reset', ['token' => 'test-token', 'email' => 'test@example.com']))
            ->assertOk()
            ->assertSee('data-storefront', false);

        $user = \App\User::create([
            'first_name' => 'Unverified',
            'last_name' => 'Customer',
            'email' => 'unverified@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)
            ->get(route('verification.notice'))
            ->assertOk()
            ->assertSee('data-storefront', false);
    }
}
