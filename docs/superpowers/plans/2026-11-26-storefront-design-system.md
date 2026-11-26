# Storefront Design System Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Move the storefront purchase flow to Bootstrap 5 with shared tokens and Blade components, without changing cart, pricing, or order behavior.

**Architecture:** Add a second Vite entry (`storefront.js` + `storefront.scss`) and a new `site.layouts.storefront` shell. Convert pages in phases; account and policy pages keep `site.master` and MDB/jQuery. Shared anonymous Blade components live under `resources/views/components/storefront/`.

**Tech Stack:** Laravel 13, PHP 8.3, Bootstrap 5.3.9, Font Awesome 6, Vite 7, Sass, PHPUnit 12.

**Spec:** `docs/superpowers/specs/2026-11-26-storefront-design-system-design.md`

## Global Constraints

- Preserve routes, controllers, cart payloads, prices, tax, delivery notice copy, and order flow.
- Orange `#ffa500` is primary; text on brand is `#111111`. Black chrome. No purple gradients.
- Money format is `₱ ` + `number_format($amount, 2)` everywhere.
- Converted pages load no jQuery and no MDB assets; old pages keep both until phase two.
- Only spec tokens may set color. No inline hex values in converted views.
- Every step ends with `php artisan test --compact` green and `npm run build` passing.
- Do not touch admin/staff layouts, `resources/js/app.js`, or account pages.

## Review Focus

- Bootstrap 5 modal open/close on shop and category, including the quantity field and Buy Now POST.
- Cart quantity update and remove still post the same fields and routes.
- Delivery notice appears once in cart, once in checkout, once in confirmation, with identical copy.
- Mobile 390px purchase flow has no horizontal overflow.
- Receiver checkbox toggle works without jQuery on checkout.

---

### Task 1: Shell, tokens, assets, home

**Files:**
- Create: `resources/sass/storefront.scss`
- Create: `resources/js/storefront.js`
- Create: `resources/views/site/layouts/storefront.blade.php`
- Create: `resources/views/components/storefront/navbar.blade.php`
- Create: `resources/views/components/storefront/footer.blade.php`
- Create: `resources/views/components/storefront/flash.blade.php`
- Create: `resources/views/components/storefront/delivery-notice.blade.php`
- Modify: `vite.config.js`
- Modify: `resources/views/site/pages/homepage.blade.php`
- Modify: `tests/TestCase.php`
- Test: `tests/Feature/StorefrontShellTest.php`

**Interfaces:**
- Produces: layout `site.layouts.storefront` with `@yield('title')`, `@yield('hero')`, `@yield('content')`, `@yield('scripts')`; body carries `data-storefront`.
- Produces: `<x-storefront.flash />`, `<x-storefront.delivery-notice />`.
- Produces: `resources/js/storefront.js` Vite input.

- [ ] **Step 1: Write the failing shell test**

Create `tests/Feature/StorefrontShellTest.php`:

```php
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

    public function test_unconverted_pages_keep_the_legacy_shell(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertDontSee('data-storefront', false);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --compact --filter=StorefrontShellTest`

Expected: FAIL; home does not contain `data-storefront`.

- [ ] **Step 3: Prevent Vite manifest lookups in tests**

Modify `tests/TestCase.php` `setUp()` to call `$this->withoutVite();` after `parent::setUp();`. Without it, a missing `public/build/manifest.json` breaks every converted page test.

- [ ] **Step 4: Add the storefront frontend entry**

Create `resources/js/storefront.js`:

```js
import '../sass/storefront.scss';
import 'bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
```

Create `resources/sass/storefront.scss` with the token block from the spec, then `@use 'bootstrap/scss/bootstrap' with ($primary: #ffa500);` before token declarations. Add only storefront styles: `.sf-navbar`, `.sf-footer`, `.sf-money`, `.sf-delivery-note`, `.sf-product-image`, `.sf-page`.

Modify `vite.config.js` input to `['resources/js/app.js', 'resources/js/storefront.js']`.

- [ ] **Step 5: Create the shell and components**

`site.layouts.storefront` renders `<html lang="en">`, `@vite('resources/js/storefront.js')`, `<body data-storefront>`, `<x-storefront.navbar />`, `@yield('hero')`, `<main class="sf-page">@yield('content')</main>`, `<x-storefront.footer />`, `@yield('scripts')`.

Navbar: `navbar navbar-expand-lg navbar-dark bg-dark sticky-top`; brand `/assets/images/LogoMJC.png`; links Home, Shop, About, Contact with `active` via `request()->routeIs()`; Cart with count badge; guest Login/Register; auth Orders and dropdown using `data-bs-toggle="dropdown"`.

Footer: four columns with the existing links, `© 2020-{{ date('Y') }}` and home link.

Flash: Bootstrap 5 alerts with `btn-close` and `data-bs-dismiss="alert"` for validation errors, session success, session error.

Delivery notice: move the exact copy and mailto link from `resources/views/site/includes/delivery-notice.blade.php`; render in `<p class="sf-delivery-note">`.

- [ ] **Step 6: Convert the home page**

`homepage.blade.php` extends `site.layouts.storefront`. Hero section (`@section('hero')`) is a Bootstrap 5 carousel with `factory.jpg` and `factory2.jpg`, fixed height via `.sf-hero`. Content keeps the About New MJC text, building image, and three service images/captions in a Bootstrap grid.

- [ ] **Step 7: Run tests and build**

Run: `php artisan test --compact --filter=StorefrontShellTest` → PASS.
Run: `php artisan test --compact` → 28 passed.
Run: `npm run build` → passes and lists `storefront` in the manifest.

- [ ] **Step 8: Commit**

```bash
git add resources/sass/storefront.scss resources/js/storefront.js resources/views/site/layouts/storefront.blade.php resources/views/components/storefront resources/views/site/pages/homepage.blade.php vite.config.js tests/TestCase.php tests/Feature/StorefrontShellTest.php
git commit -m "feat(storefront): add Bootstrap 5 shell"
```

---

### Task 2: Shop and category cards

**Files:**
- Create: `resources/views/components/storefront/money.blade.php`
- Create: `resources/views/components/storefront/product-card.blade.php`
- Create: `resources/views/components/storefront/cart-modal.blade.php`
- Modify: `resources/views/site/pages/shop.blade.php`
- Modify: `resources/views/site/pages/category.blade.php`
- Test: `tests/Feature/StorefrontShopTest.php`

**Interfaces:**
- Consumes: `site.layouts.storefront`.
- Produces: `<x-storefront.money :amount="$item->price_stocks" />`.
- Produces: `<x-storefront.product-card :item="$item" />`; card links to `site.product`, opens `#addtocart{id}`.
- Produces: `<x-storefront.cart-modal :item="$item" />`; posts `id`, `name`, `quantity`, `buynow` to `cart.store`.

- [ ] **Step 1: Write the failing shop test**

Create `tests/Feature/StorefrontShopTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Category;
use App\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_lists_items_with_prices(): void
    {
        $this->seed();
        $item = Item::where('stocks', '>', 0)->firstOrFail();

        $this->get(route('site.shop'))
            ->assertOk()
            ->assertSee('data-storefront', false)
            ->assertSee('₱ '.number_format($item->price_stocks, 2));
    }

    public function test_category_lists_items_with_prices(): void
    {
        $this->seed();
        $category = Category::whereHas('items')->firstOrFail();
        $item = Item::where('category_id', $category->id)->where('stocks', '>', 0)->firstOrFail();

        $this->get(route('site.categories', $category))
            ->assertOk()
            ->assertSee('data-storefront', false)
            ->assertSee('₱ '.number_format($item->price_stocks, 2));
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --compact --filter=StorefrontShopTest`

Expected: FAIL; shop still renders the legacy shell.

- [ ] **Step 3: Build the three components**

`money.blade.php`: `@props(['amount'])`, renders `<span class="sf-money">₱ {{ number_format((float) $amount, 2) }}</span>`.

`product-card.blade.php`: `@props(['item'])`; card with `sf-product-image` container, `item->image`, name link to `site.product`, money, `Stocks: {{ $item->stocks }}`, and Buy button with `data-bs-toggle="modal"` targeting `#addtocart{{ $item->id }}`.

`cart-modal.blade.php`: `@props(['item'])`; Bootstrap 5 modal with id `addtocart{{ $item->id }}`, quantity input, hidden `id` and `name`, Buy Now submit, form action `action('CartController@store')`.

- [ ] **Step 4: Convert shop and category**

Both extend `site.layouts.storefront`. Keep the quote CTA, category list, `$items->links()`. Remove page-local `<style>` and inline colors. Render one `product-card` and one `cart-modal` per item. No hidden `price` input.

- [ ] **Step 5: Verify tests, modal, and build**

Run: `php artisan test --compact --filter=StorefrontShopTest` → PASS.
Manual: open `/shop`, click Buy, modal appears, submit adds the item. Repeat at 390px.
Run: `npm run build`.

- [ ] **Step 6: Commit**

```bash
git add resources/views/components/storefront resources/views/site/pages/shop.blade.php resources/views/site/pages/category.blade.php tests/Feature/StorefrontShopTest.php
git commit -m "feat(storefront): rebuild shop cards on Bootstrap 5"
```

---

### Task 3: Product page

**Files:**
- Modify: `resources/views/site/pages/product.blade.php`
- Test: `tests/Feature/StorefrontShopTest.php`

**Interfaces:**
- Consumes: `money`, `flash`, layout.
- Preserves: form action `CartController@store`, fields `id`, `name`, `quantity`.

- [ ] **Step 1: Extend the shop test**

Add `test_product_page_shows_price` asserting `GET route('site.product', $item)` returns 200, contains `data-storefront`, and shows the formatted price.

- [ ] **Step 2: Run it to verify failure**

Run: `php artisan test --compact --filter=test_product_page_shows_price`

Expected: FAIL; legacy shell.

- [ ] **Step 3: Convert the page**

Two-column layout: image left with `sf-product-image`, right side name, `money`, description, stock, quantity input with `min="1"`, add-to-cart button, Go Back link. Keep the same POST route and field names.

- [ ] **Step 4: Run test and build**

Run: `php artisan test --compact --filter=StorefrontShopTest` → PASS.
Run: `npm run build`.

- [ ] **Step 5: Commit**

```bash
git add resources/views/site/pages/product.blade.php tests/Feature/StorefrontShopTest.php
git commit -m "feat(storefront): rebuild product page"
```

---

### Task 4: Cart

**Files:**
- Create: `resources/views/components/storefront/order-summary.blade.php`
- Modify: `resources/views/site/pages/cart.blade.php`
- Test: `tests/Feature/CheckoutDeliveryNoticeTest.php`

**Interfaces:**
- Produces: `<x-storefront.order-summary :items="Cart::content()" :total="Cart::total()" />`; root class `sf-order-summary`; line subtotal is `qty * $item->price`; renders total and `<x-storefront.delivery-notice />`.
- Preserves: `cart.update` form fields `proID`, `qty`; `cart.remove` DELETE form; Clear Cart route.

- [ ] **Step 1: Extend the cart test**

In `CheckoutDeliveryNoticeTest`, assert the cart response contains `data-storefront` and `sf-order-summary`, in addition to the delivery notice.

- [ ] **Step 2: Run it to verify failure**

Run: `php artisan test --compact --filter=CheckoutDeliveryNoticeTest`

Expected: FAIL on the new markers.

- [ ] **Step 3: Build the summary and convert the cart**

`order-summary` renders a Bootstrap list group of `name`, `pcs. ×qty`, line subtotal with `money`, then `Total` with `money`. Cart page uses a `table-responsive` table for items with thumbnail (`sf-cart-thumb`), quantity update form, remove form, and the summary component in the right column. Empty state keeps the copy and Continue Shopping button.

- [ ] **Step 4: Verify**

Run: `php artisan test --compact --filter=CheckoutDeliveryNoticeTest` → PASS.
Manual: update quantity and remove an item; totals stay consistent; notice appears once.

- [ ] **Step 5: Commit**

```bash
git add resources/views/components/storefront/order-summary.blade.php resources/views/site/pages/cart.blade.php tests/Feature/CheckoutDeliveryNoticeTest.php
git commit -m "feat(storefront): rebuild cart on components"
```

---

### Task 5: Checkout

**Files:**
- Modify: `resources/views/site/pages/checkout.blade.php`
- Modify: `resources/js/storefront.js`
- Test: `tests/Feature/CheckoutConfirmationTest.php`

**Interfaces:**
- Produces: `<x-storefront.form-field name="city" label="City" :value="old('city')" />` for every input; root class `sf-form-field`; extra HTML attributes such as `disabled` are merged onto the input.
- Preserves: field names `firstName`, `lastName`, `email`, `address`, `city`, `zip`, `mobile_num`, `notes`, `deliver_to`, `deliver_to_address`, `paymentMethod`.
- Preserves: receiver toggle ids `checker`, `receiver`, `receiver_address`.

- [ ] **Step 1: Extend the checkout test**

In `CheckoutConfirmationTest`, add a GET `/checkout` assertion for `data-storefront`, `sf-form-field`, and the delivery notice.

- [ ] **Step 2: Run it to verify failure**

Run: `php artisan test --compact --filter=CheckoutConfirmationTest`

Expected: FAIL on the new markers.

- [ ] **Step 3: Convert the form**

Two columns: form card with `form-field` components, receiver checkbox with label "Deliver to a different person", payment radios, Place order button; right column uses `order-summary`. Keep all names and the POST action. Email uses `form-field` with the `disabled` attribute.

- [ ] **Step 4: Replace jQuery toggle**

Add to `storefront.js` a `DOMContentLoaded` handler: on `#checker` change, toggle `#receiver` and `#receiver_address` with `hidden`, set/remove `required` on `#deliver_to` and `#deliver_to_address`, clear values when unchecked.

- [ ] **Step 5: Verify**

Run: `php artisan test --compact --filter=CheckoutConfirmationTest` → PASS.
Manual: check Receiver toggles both fields; submit with and without receiver; confirmation shows the order number.

- [ ] **Step 6: Commit**

```bash
git add resources/views/site/pages/checkout.blade.php resources/js/storefront.js tests/Feature/CheckoutConfirmationTest.php
git commit -m "feat(storefront): rebuild checkout form"
```

---

### Task 6: Confirmation page

**Files:**
- Modify: `resources/views/site/pages/order-confirmation.blade.php`
- Test: `tests/Feature/CheckoutConfirmationTest.php`

**Interfaces:**
- Consumes: `money`, `delivery-notice`, layout.
- Preserves: order number, total, payment label, View order, Continue shopping.

- [ ] **Step 1: Extend the confirmation test**

Assert the confirmation response contains `data-storefront` and `sf-confirmation`.

- [ ] **Step 2: Run it to verify failure**

Run: `php artisan test --compact --filter=CheckoutConfirmationTest`

Expected: FAIL on markers.

- [ ] **Step 3: Convert the page**

Centered card with order number, total using `money`, payment method, delivery notice, View order and Continue shopping buttons. Root wrapper carries `sf-confirmation`.

- [ ] **Step 4: Verify and build**

Run: `php artisan test --compact --filter=CheckoutConfirmationTest` → PASS.
Run: `npm run build`.

- [ ] **Step 5: Commit**

```bash
git add resources/views/site/pages/order-confirmation.blade.php tests/Feature/CheckoutConfirmationTest.php
git commit -m "feat(storefront): rebuild order confirmation"
```

---

### Task 7: Cleanup and full verification

**Files:**
- Modify: `resources/views/site/pages/*.blade.php` only if a converted page still references a legacy asset.
- Test: full suite.

**Interfaces:**
- Consumes: all previous tasks.

- [ ] **Step 1: Grep converted pages for legacy assets**

Run: `grep -rn "mdb\|jquery\|site.includes.styles\|site.includes.messages" resources/views/site/pages/{homepage,shop,category,product,cart,checkout,order-confirmation}.blade.php`

Expected: no matches. If a match appears, remove it in the same commit.

- [ ] **Step 2: Run the full suite**

Run: `php artisan test --compact` → all tests pass.

- [ ] **Step 3: Build and rendered check**

Run: `npm run build`.
Open `/`, `/shop`, `/shop/{category}`, `/product/{id}`, `/cart`, `/checkout`, confirmation at 1274px and 390px. Confirm no horizontal scroll, one money format, delivery notice once per page, modals open, quantity update works.

- [ ] **Step 4: Commit**

```bash
git add -A resources/views/site resources/js/storefront.js resources/sass/storefront.scss
git commit -m "chore(storefront): verify Bootstrap 5 migration"
```
