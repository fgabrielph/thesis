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
                ->assertSee('data-storefront', false);
        }
    }
}
