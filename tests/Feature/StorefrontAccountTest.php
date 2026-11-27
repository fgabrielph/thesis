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
}
