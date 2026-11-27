<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontStaticPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_pages_use_the_storefront_shell(): void
    {
        $this->seed();

        foreach (['about', 'contact', 'faqs', 'policy', 'terms', 'rr', 'site.inquire'] as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee('data-storefront', false);
        }
    }
}
