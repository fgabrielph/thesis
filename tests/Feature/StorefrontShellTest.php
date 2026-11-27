<?php

namespace Tests\Feature;

use Tests\TestCase;

class StorefrontShellTest extends TestCase
{
    public function test_home_uses_the_storefront_shell(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('data-storefront', false);
    }

    public function test_all_storefront_pages_use_the_shell(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('data-storefront', false);
    }
}
