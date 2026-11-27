# Storefront Phase Two Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Convert every remaining customer page to the Bootstrap 5 storefront shell, then delete MDB, jQuery, and the legacy storefront layout.

**Architecture:** Reuse `site.layouts.storefront` and the existing `storefront/*` components. Add one `account-nav` component for the account area. Replace DataTables with plain responsive tables and rewrite remaining jQuery behaviors in `storefront.js`.

**Tech Stack:** Laravel 13, PHP 8.3, Bootstrap 5.3.9, Font Awesome 6, Vite 7, PHPUnit 12.

**Spec:** `docs/superpowers/specs/2026-11-26-storefront-design-system-design.md` (phase two)

## Global Constraints

- Preserve routes, controllers, form field names, uploads, prices, and order data.
- No new features. Copy changes limited to typos and duplicate labels.
- Converted pages use only `site.layouts.storefront`; no jQuery, MDB, or `site.includes.styles`.
- Money uses `<x-storefront.money>`.
- Forms use `<x-storefront.form-field>` where the field is a simple input.
- Every task ends with `php artisan test --compact` green and `npm run build` passing.
- Do not touch admin/staff.

## Review Focus

- Profile modal open/close and all five profile forms after Bootstrap 5 attribute changes.
- Orders and custom-order tables remain readable at 390px without page overflow.
- File upload previews work without jQuery on proof, custom order, and inquiry forms.
- Auth forms submit the same field names and routes.
- Legacy shell deletion does not break any route that still extends `site.master`.

---

### Task 1: Account navigation and profile

**Files:**
- Create: `resources/views/components/storefront/account-nav.blade.php`
- Modify: `resources/views/site/accounts/profile.blade.php`
- Test: `tests/Feature/StorefrontAccountTest.php`

**Interfaces:**
- Produces: `<x-storefront.account-nav />` with active links to `account.index`, `orders.index`, `custom_order.index`.
- Preserves: profile form routes `account.picture`, `account.name`, `account.address`, `account.birthday`, `account.password`, `account.mobile`.

- [ ] **Step 1: Write the failing account test**

Create `tests/Feature/StorefrontAccountTest.php` with seeded customer:

```php
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
```

- [ ] **Step 2: Run it**

Run: `php artisan test --compact --filter=StorefrontAccountTest`
Expected: FAIL, legacy shell.

- [ ] **Step 3: Convert profile**

`account-nav` renders three links with `active` from `request()->routeIs()`.

Profile extends the storefront layout, adds page heading, left avatar card plus `account-nav`, right card with the existing forms. Convert every modal trigger and close control to Bootstrap 5: `data-bs-toggle="modal"`, `data-bs-target="#id"`, `data-bs-dismiss="modal"`, `btn-close`. Keep every form action, method, `@csrf`, field name, and upload input. Add `sf-profile` to the page wrapper.

- [ ] **Step 4: Verify**

Run filter test → PASS. Manually open each of the five modals and submit one form.
Run: `php artisan test --compact`.

- [ ] **Step 5: Commit**

```bash
git add resources/views/components/storefront/account-nav.blade.php resources/views/site/accounts/profile.blade.php tests/Feature/StorefrontAccountTest.php
git commit -m "feat(storefront): convert account profile"
```

---

### Task 2: Orders list, order detail, invoice

**Files:**
- Modify: `resources/views/site/accounts/orders.blade.php`
- Modify: `resources/views/site/accounts/showorder.blade.php`
- Modify: `resources/views/site/accounts/invoice.blade.php`
- Test: `tests/Feature/StorefrontAccountTest.php`

**Interfaces:**
- Consumes: `account-nav`, `money`, layout.
- Preserves: `orders.show`, `orders.update`, `invoice.show`, `proof.add` links.

- [ ] **Step 1: Extend the account test**

Add assertions that `GET orders.index`, `orders.show` for a seeded customer order, and `invoice.show` when `invoice_id` exists return 200 with `data-storefront`.

- [ ] **Step 2: Run to verify failure**

Run: `php artisan test --compact --filter=StorefrontAccountTest`
Expected: FAIL, legacy shell.

- [ ] **Step 3: Convert the three pages**

Orders: heading, Custom Orders button, Bootstrap table inside `.table-responsive`. Columns: order number, customer, amount via `money`, quantity, status badge, created date, actions. No DataTables.

Order detail: card with order number, item table, subtotal via `money`, total via `money`, proof upload link, Go Back.

Invoice: card with invoice id, date, customer fields, amount via `money`, payment status, Go Back. Keep `P`/`₱` consistent with `money`.

Add `sf-orders`, `sf-order-detail`, `sf-invoice` marker classes.

- [ ] **Step 4: Verify**

Run filter test → PASS.
Manual: order table at 390px scrolls inside its card, no page overflow.

- [ ] **Step 5: Commit**

```bash
git add resources/views/site/accounts/orders.blade.php resources/views/site/accounts/showorder.blade.php resources/views/site/accounts/invoice.blade.php tests/Feature/StorefrontAccountTest.php
git commit -m "feat(storefront): convert orders and invoice"
```

---

### Task 3: Custom orders and proof upload

**Files:**
- Modify: `resources/views/site/accounts/custom_order.blade.php`
- Modify: `resources/views/site/accounts/show_custom.blade.php`
- Modify: `resources/views/site/accounts/addproof.blade.php`
- Modify: `resources/js/storefront.js`
- Test: `tests/Feature/StorefrontAccountTest.php`

**Interfaces:**
- Preserves: `custom_order.show`, `custom_order.payment`, `proof.upload`, `proof.add`.
- Produces: vanilla upload preview for `#imgInp`; payment toggle ids `credit`, `bank`, `bankt`.

- [ ] **Step 1: Extend the test**

Assert `GET custom_order.index`, `custom_order.show`, and `proof.add` return 200 with `data-storefront`.

- [ ] **Step 2: Run to verify failure**

Run: `php artisan test --compact --filter=StorefrontAccountTest`
Expected: FAIL.

- [ ] **Step 3: Convert the pages**

Custom order list: responsive table, status badge, amount via `money`, view action. No DataTables.

Custom order detail: remove the external `http://anthonyterrien.com/...jquery.knob.min.js` script and the dial. Show quantity as text. Keep payment forms, upload form, and toggles. Convert controls to Bootstrap 5.

Proof upload: card with current image, file input, preview, Submit, Go Back. Use `@method('PUT')` and `enctype="multipart/form-data"`.

Add to `storefront.js`: `FileReader` preview for any `input[type=file][data-preview="#img"]`; show/hide `#bankt` when `#bank`/`#credit` change. No jQuery.

- [ ] **Step 4: Verify**

Run filter test → PASS.
Manual: choose a file on proof and custom order forms, image preview updates; payment radio toggles bank fields.

- [ ] **Step 5: Commit**

```bash
git add resources/views/site/accounts/custom_order.blade.php resources/views/site/accounts/show_custom.blade.php resources/views/site/accounts/addproof.blade.php resources/js/storefront.js tests/Feature/StorefrontAccountTest.php
git commit -m "feat(storefront): convert custom orders and uploads"
```

---

### Task 4: Static pages

**Files:**
- Modify: `resources/views/site/pages/about.blade.php`
- Modify: `resources/views/site/pages/contact.blade.php`
- Modify: `resources/views/site/pages/faqs.blade.php`
- Modify: `resources/views/site/pages/terms.blade.php`
- Modify: `resources/views/site/pages/privacypolicy.blade.php`
- Modify: `resources/views/site/pages/returns_policy.blade.php`
- Modify: `resources/views/site/pages/inquire.blade.php`
- Test: `tests/Feature/StorefrontStaticPagesTest.php`

**Interfaces:**
- Consumes: layout, `form-field`, upload preview behavior from Task 3.
- Preserves: `site.inquire` PUT route and `enctype`.

- [ ] **Step 1: Write the failing static-page test**

Assert `GET` for `about`, `contact`, `faqs`, `policy`, `terms`, `rr`, `site.inquire` each return 200 and contain `data-storefront`.

- [ ] **Step 2: Run to verify failure**

Run: `php artisan test --compact --filter=StorefrontStaticPagesTest`
Expected: FAIL.

- [ ] **Step 3: Convert the pages**

About: hero image `picture.jpg`, preserved paragraphs, services grid if present.

Contact: location image, address, phone numbers, email.

FAQ: preserved questions/answers as Bootstrap accordion or definition sections.

Terms, privacy, returns: preserved copy in a readable `col-lg-10 mx-auto` container.

Inquire: preserved form fields and file upload; use `form-field` for text inputs, `@method('PUT')`, `enctype`, vanilla preview.

- [ ] **Step 4: Verify**

Run filter test → PASS. Check long policy pages at 390px for overflow.

- [ ] **Step 5: Commit**

```bash
git add resources/views/site/pages/about.blade.php resources/views/site/pages/contact.blade.php resources/views/site/pages/faqs.blade.php resources/views/site/pages/terms.blade.php resources/views/site/pages/privacypolicy.blade.php resources/views/site/pages/returns_policy.blade.php resources/views/site/pages/inquire.blade.php tests/Feature/StorefrontStaticPagesTest.php
git commit -m "feat(storefront): convert static pages"
```

---

### Task 5: Auth pages

**Files:**
- Modify: `resources/views/auth/login.blade.php`
- Modify: `resources/views/auth/register.blade.php`
- Modify: `resources/views/auth/verify.blade.php`
- Modify: `resources/views/auth/passwords/email.blade.php`
- Modify: `resources/views/auth/passwords/reset.blade.php`
- Modify: `resources/views/auth/passwords/confirm.blade.php`
- Test: `tests/Feature/StorefrontAuthTest.php`

**Interfaces:**
- Preserves: routes `login`, `register`, `password.email`, `password.reset`, `password.confirm`, `verification.notice`.
- Preserves: field names `email`, `password`, `password_confirmation`, `name`, `first_name`, `last_name`, `token`.

- [ ] **Step 1: Write the failing auth test**

Assert `GET login`, `register`, `password.request` return 200 with `data-storefront`.

- [ ] **Step 2: Run to verify failure**

Run: `php artisan test --compact --filter=StorefrontAuthTest`
Expected: FAIL.

- [ ] **Step 3: Convert auth views**

Each extends `site.layouts.storefront`, renders a centered `col-md-6 col-lg-5` card, uses `form-field` for inputs, keeps validation errors and all field names. Password reset keeps the hidden `token` field. Verify notice keeps its resend form.

- [ ] **Step 4: Verify**

Run filter test → PASS. Manually submit login with seeded customer; invalid credentials show errors.

- [ ] **Step 5: Commit**

```bash
git add resources/views/auth tests/Feature/StorefrontAuthTest.php
git commit -m "feat(storefront): convert auth pages"
```

---

### Task 6: Delete the legacy storefront

**Files:**
- Delete: `resources/views/site/master.blade.php`
- Delete: `resources/views/site/includes/*` after confirming no references
- Modify: `tests/Feature/StorefrontShellTest.php`
- Modify: `tests/TestCase.php` only if a helper is no longer used.

**Interfaces:**
- Consumes: every previous task.

- [ ] **Step 1: Prove no legacy references**

Run: `grep -rn "site.master\|site.includes.styles\|site.includes.messages\|site.includes.carousel\|site.includes.navbar\|site.includes.footer" resources/views`

Expected: no matches. Fix any remaining view before deleting.

- [ ] **Step 2: Update the shell test**

Replace `test_unconverted_pages_keep_the_legacy_shell` with an assertion that `about` now contains `data-storefront`.

- [ ] **Step 3: Delete legacy files and assets**

Delete `site/master.blade.php`, then delete each file under `site/includes/` that grep no longer references. Remove MDB/jQuery/DataTables references from any remaining view.

Do not delete `public/assets/images`; pages still use those images.

- [ ] **Step 4: Verify**

Run: `php artisan test --compact` → all tests pass.
Run: `npm run build` → passes.
Rendered: every storefront route at 1274px and 390px; no page loads jQuery or MDB; no horizontal overflow.

- [ ] **Step 5: Commit**

```bash
git add -A resources/views/site resources/views/auth tests resources/js
git commit -m "chore(storefront): remove legacy MDB and jQuery layout"
```
