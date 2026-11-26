# Remove Silent Cart Tax Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Remove the accidental 21% cart tax so cart, checkout, and stored order totals equal the sum of item prices.

**Architecture:** Add a minimal application-level `config/cart.php` that sets `tax` to `0`. The package's `mergeConfigFrom` keeps every other vendor default. Two feature tests pin the cart total and the checkout `grand_total`. Historical orders are not modified.

**Tech Stack:** PHP 8.3, Laravel 13, PHPUnit 12, `redx1t/shoppingcart` 3.6.

**Spec:** Decision recorded 2026-11-26 in conversation: the 21% rate is the package default, not a business rule; remove it. No standalone spec file.

## Global Constraints

- Tax rate must be `0`. Do not add VAT, tax rows, or tax copy.
- Do not mutate existing `orders` or `suborders` rows.
- Keep cart and checkout markup unchanged.
- Repository check: `php artisan test --compact` → 20 passed (18 existing + 2 new).
- Format changed PHP with `vendor/bin/pint`.

## Review Focus

- Cart quantity greater than 1 must not re-introduce tax multiplication. Covered by Task 1, test 1.
- Checkout must persist exactly the line sum in `orders.grand_total`. Covered by Task 1, test 2.
- The app config override must survive the vendor package's `mergeConfigFrom`. Covered by Task 1, test 1 assertion on `config('cart.tax')`.
- Sessions that already hold cart items before deploy keep their stored `priceTax` until those items are removed or re-added. Verified manually in Task 1, Step 7.
- A cached config built before deploy keeps tax at 21. Verified manually in Task 1, Step 7.

---

### Task 1: Remove the cart tax rate

**Files:**
- Create: `config/cart.php`
- Test: `tests/Feature/CartTaxTest.php`

**Interfaces:**
- Consumes: `route('cart.store')`, `route('cart.index')`, `route('checkout.store')`; `App\Item`, `App\Order`, `App\User`; `config('cart.tax')`.
- Produces: `config('cart.tax') === 0`; cart and checkout totals equal `item->price_stocks * quantity`.

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/CartTaxTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Item;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTaxTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_total_matches_item_subtotal(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 0)->firstOrFail();
        $quantity = 2;

        $this->addToCart($item, $quantity);

        $this->assertSame(0, config('cart.tax'));
        $this->assertSame(
            number_format($item->price_stocks * $quantity, 2),
            \Gloudemans\Shoppingcart\Facades\Cart::total()
        );

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('₱'.number_format($item->price_stocks * $quantity, 2));
    }

    public function test_checkout_stores_grand_total_without_tax(): void
    {
        $this->seed();

        $item = Item::where('stocks', '>', 0)->firstOrFail();
        $quantity = 2;

        $this->addToCart($item, $quantity);

        $user = User::create([
            'first_name' => 'Tax',
            'last_name' => 'Customer',
            'email' => 'cart-tax@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $this->actingAs($user)
            ->post(route('checkout.store'), [
                'firstName' => 'Tax',
                'lastName' => 'Customer',
                'city' => 'Manila',
                'address' => '1 Test Street',
                'zip' => '1000',
                'mobile_num' => '09171234567',
                'paymentMethod' => 'cod',
            ])
            ->assertRedirect();

        $order = Order::where('user_id', $user->id)->latest('id')->firstOrFail();

        $this->assertEquals($item->price_stocks * $quantity, $order->grand_total);
    }

    private function addToCart(Item $item, int $quantity): void
    {
        $this->post(route('cart.store'), [
            'id' => $item->id,
            'name' => $item->name,
            'quantity' => $quantity,
            'price' => $item->price_stocks,
        ]);
    }
}
```

- [ ] **Step 2: Run tests to verify they fail**

Run: `php artisan test --compact --filter=CartTaxTest`

Expected: FAIL. Test 1 fails on `config('cart.tax')` being `21` and the cart total being `6,050.00` instead of `5,000.00`. Test 2 fails with `6050.00` not equal to `5000`.

- [ ] **Step 3: Create the app-level cart config**

Create `config/cart.php`:

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Tax Rate
    |--------------------------------------------------------------------------
    |
    | Prices in this application already include tax. Set the rate to zero so
    | the cart total matches the displayed item subtotals.
    |
    */

    'tax' => 0,

];
```

The package merges its remaining defaults (`format`, `database`, `destroy_on_logout`) via `mergeConfigFrom`.

- [ ] **Step 4: Run tests to verify they pass**

Run: `php artisan test --compact --filter=CartTaxTest`

Expected: PASS, 2 tests, 6 assertions.

- [ ] **Step 5: Run the full suite and formatter**

Run: `php artisan test --compact`

Expected: 20 passed.

Run: `vendor/bin/pint --test config/cart.php tests/Feature/CartTaxTest.php`

Expected: passed.

- [ ] **Step 6: Commit**

```bash
git add config/cart.php tests/Feature/CartTaxTest.php
git commit -m "fix(cart): remove accidental 21 percent tax"
```

- [ ] **Step 7: Manual verification**

Run: `php artisan config:clear` then `php artisan tinker --execute 'echo config("cart.tax");'`

Expected: `0`.

On deploy, rebuild the config cache after release: `php artisan config:cache`. A cache built before this release keeps `tax` at `21`.

Clear the browser cart before checking totals: sessions created before deploy keep the stored 21% `priceTax` until their items are removed or re-added. Confirm `/cart` shows `₱5,000.00` for two items at `₱2,500.00`, and `/checkout` shows the same total.

## Out of Scope

- Historical orders keep their 21% `grand_total`; do not rewrite them.
- Reports that compare pre-fix and post-fix totals will mix values; no report change in this plan.
- Product card prices, checkout field consistency, and mobile layout issues remain separate work.
