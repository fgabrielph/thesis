# Admin Design System Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Give admin and staff one shared token palette and component set, without changing routes, permissions, or operator workflows.

**Architecture:** Extend `resources/sass/app.scss` with admin tokens; add `resources/views/components/ui/*`; add shell markers to both layouts; convert core pages in place. Custom-order jQuery dials become Bootstrap progress bars; remaining jQuery interactions move to `resources/js/app.js`.

**Tech Stack:** Laravel 13, PHP 8.3, AdminLTE 4, Bootstrap 5.3.9, DataTables 2, Vite 7, PHPUnit 12.

**Spec:** `docs/superpowers/specs/2026-11-27-admin-design-system-design.md`

## Global Constraints

- Preserve routes, guards, permissions, table columns, filters, forms, and actions.
- No new features. Fix broken UI only.
- One token palette: orange `#ffa500` primary, `#111111` on-brand, neutral surfaces.
- No inline hex values in converted admin/staff views.
- Keep table ids `orderTable`, `defTable`, `atkTable`.
- Every task ends with `php artisan test --compact` green and `npm run build` passing.
- Convert both admin and staff counterparts where both exist.

## Review Focus

- DataTables still initialises after table markup moves inside components.
- DataTables search/pagination controls remain styled and usable at 390px.
- Status badge mapping matches every status the controllers emit.
- Custom-order bank toggle and image preview work without jQuery.
- Sidebar active state and orange primary remain readable on the dark sidebar.

---

### Task 1: Tokens, shared components, shell markers, custom-order dial fix

**Files:**
- Modify: `resources/sass/app.scss`
- Modify: `resources/js/app.js`
- Create: `resources/views/components/ui/page-header.blade.php`
- Create: `resources/views/components/ui/stat-card.blade.php`
- Create: `resources/views/components/ui/status-badge.blade.php`
- Create: `resources/views/components/ui/table-shell.blade.php`
- Create: `resources/views/components/ui/form-field.blade.php`
- Create: `resources/views/components/ui/empty-state.blade.php`
- Create: `resources/views/components/ui/money.blade.php`
- Modify: `resources/views/admin/master.blade.php`
- Modify: `resources/views/staff/master.blade.php`
- Modify: `resources/views/admin/customorders/customorder.blade.php`
- Modify: `resources/views/admin/customorders/modifyorder.blade.php`
- Test: `tests/Feature/AdminShellTest.php`

**Interfaces:**
- Produces: `<x-ui.page-header title="..." subtitle="..." />` with `$slot` actions.
- Produces: `<x-ui.stat-card label value href icon tone />`.
- Produces: `<x-ui.status-badge status="Pending" />`; tone map covers Pending, Confirmed, On Delivery, Completed, Return, Declined, Paid, Unpaid.
- Produces: `<x-ui.table-shell title="...">` with `toolbar`, `table` slots, `empty`, `emptyMessage` props.
- Produces: `<x-ui.form-field name label value type required />`; extra attributes merge.
- Produces: `<x-ui.empty-state message="...">` with action slot.
- Produces: `<x-ui.money amount="..." />`.
- Produces: body attribute `data-admin-shell` / `data-staff-shell`.

- [ ] **Step 1: Write the failing shell test**

Create `tests/Feature/AdminShellTest.php`:

```php
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
            ->assertSee('data-admin-shell', false);
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
```

- [ ] **Step 2: Run it to verify failure**

Run: `php artisan test --compact --filter=AdminShellTest`
Expected: FAIL; body markers absent.

- [ ] **Step 3: Add tokens and layout markers**

In `app.scss` define the token block from the spec and map `.btn-primary`, links, focus rings, and `.sidebar-menu .nav-link.active` to `--admin-brand`. Keep the existing table badge overrides.

Add `data-admin-shell` / `data-staff-shell` to the `<body>` tags in the two master layouts. Do not change layout structure.

- [ ] **Step 4: Build the `ui/*` components**

Each component has one owner and no page-specific logic. `status-badge` uses Bootstrap `text-bg-*` classes. `table-shell` renders a card with `card-title`, a toolbar slot, `table-responsive`, the `table` slot, and an empty row when `empty` is true. It must not set or wrap the table element itself; pages keep their `<table id="...">`.

- [ ] **Step 5: Move custom-order interactions to vanilla JS**

In `app.js`:

- If `#credit`, `#bank`, `#bankt` exist, toggle `#bankt.hidden` when the radio changes; run once on load.
- For every `input[type="file"][data-preview]`, preview with `FileReader` into the selector.
- Guard both blocks so they do not run on pages without those elements.

In `customorder.blade.php` and `modifyorder.blade.php`:

- Delete the `http://anthonyterrien.com/...jquery.knob.min.js` script and the `$('.dial').knob(...)` block.
- Replace the dial input with a Bootstrap progress bar: `width: {{ $custom_order->quantity ? round(($custom_order->completed / $custom_order->quantity) * 100) : 0 }}%`, same surrounding text.
- Remove `onclick="no_form()"` / `onclick="with_form(1)"`; keep ids `credit`, `bank`, `bankt`.
- Add `data-preview="#img"` to `#imgInp` and remove the inline `readURL` scripts.

- [ ] **Step 6: Verify**

Run filter test → PASS.
Run: `php artisan test --compact` → all pass.
Manual: open an admin custom order, switch Bank Transfer, choose an image, confirm preview.

- [ ] **Step 7: Commit**

```bash
git add resources/sass/app.scss resources/js/app.js resources/views/components/ui resources/views/admin/master.blade.php resources/views/staff/master.blade.php resources/views/admin/customorders tests/Feature/AdminShellTest.php public/build
git commit -m "feat(admin): add shared design tokens and components"
```

---

### Task 2: Dashboards

**Files:**
- Modify: `resources/views/admin/dashboard/index.blade.php`
- Modify: `resources/views/staff/dashboard/index.blade.php`
- Test: `tests/Feature/AdminShellTest.php`

**Interfaces:**
- Consumes: `ui.page-header`, `ui.stat-card`, `ui.table-shell`.
- Preserves: counts `$orders`, `$users`, `$pending_deliveries`, `$returns`, low-stock link, charts.

- [ ] **Step 1: Extend the shell test**

Assert admin dashboard contains `stat-card` and `page-header`; staff dashboard contains `stat-card`.

- [ ] **Step 2: Run to verify failure**

Run: `php artisan test --compact --filter=AdminShellTest`
Expected: FAIL on markers.

- [ ] **Step 3: Convert both dashboards**

Replace the four small boxes with `stat-card` components: New Orders → `admin_orders.index` / `staff_orders.index`; User Registrations → `customers.index` / `staff_customer.index`; On Delivery → deliveries; Returns → orders. Keep counts and icons.

Replace page headings with `page-header`. Leave the low-stock alert, item updates table (wrap with `table-shell`), and Chart.js canvases unchanged.

- [ ] **Step 4: Verify**

Run filter test → PASS. Render both dashboards at 1274px and 390px.

- [ ] **Step 5: Commit**

```bash
git add resources/views/admin/dashboard resources/views/staff/dashboard tests/Feature/AdminShellTest.php public/build
git commit -m "feat(admin): convert dashboards"
```

---

### Task 3: Orders and deliveries

**Files:**
- Modify: `resources/views/admin/orders/index.blade.php`
- Modify: `resources/views/staff/orders/index.blade.php`
- Modify: `resources/views/admin/deliveries/index.blade.php`
- Modify: `resources/views/staff/deliveries/index.blade.php`
- Test: `tests/Feature/AdminShellTest.php`

**Interfaces:**
- Consumes: `ui.page-header`, `ui.status-badge`, `ui.table-shell`.
- Preserves: ids `orderTable`, `defTable`, `atkTable`; status forms, modals, columns, filters.

- [ ] **Step 1: Extend the test**

Assert admin orders page contains `status-badge` and `table-shell`.

- [ ] **Step 2: Run to verify failure**

Run: `php artisan test --compact --filter=AdminShellTest`
Expected: FAIL.

- [ ] **Step 3: Convert pages**

Replace page headings, status badge markup, and table cards. Keep each table element, id, `thead`, forms, modals, and action buttons. Deliveries page has three tables (`orderTable`, `atkTable`, `defTable`); convert each shell without changing ids.

- [ ] **Step 4: Verify**

Run filter test → PASS.
Manual: DataTables search, sort, and paginate on orders and deliveries; 390px table scroll.

- [ ] **Step 5: Commit**

```bash
git add resources/views/admin/orders resources/views/staff/orders resources/views/admin/deliveries resources/views/staff/deliveries tests/Feature/AdminShellTest.php public/build
git commit -m "feat(admin): convert orders and deliveries"
```

---

### Task 4: Inventory

**Files:**
- Modify: `resources/views/admin/items/index.blade.php`
- Modify: `resources/views/admin/items/lowitems.blade.php`
- Modify: `resources/views/staff/items/index.blade.php`
- Modify: `resources/views/staff/items/lowitems.blade.php`
- Test: `tests/Feature/AdminShellTest.php`

**Interfaces:**
- Consumes: `ui.page-header`, `ui.table-shell`, `ui.money`.
- Preserves: ids `defTable`, `orderTable`; add/edit modals; image uploads; actions.

- [ ] **Step 1: Extend the test**

Assert admin items page contains `table-shell`; assert `assertDontSee('₱ ₱', false)`.

- [ ] **Step 2: Run to verify failure**

Run: `php artisan test --compact --filter=AdminShellTest`
Expected: FAIL.

- [ ] **Step 3: Convert**

Wrap tables in `table-shell`; keep the table elements and ids. Replace heading rows with `page-header`. Use `money` in price cells. Do not touch modal bodies except Bootstrap classes already present.

- [ ] **Step 4: Verify**

Run filter test → PASS.
Manual: open Add Item and Actions modals on both roles; DataTables search and sort.

- [ ] **Step 5: Commit**

```bash
git add resources/views/admin/items resources/views/staff/items tests/Feature/AdminShellTest.php public/build
git commit -m "feat(admin): convert inventory tables"
```

---

### Task 5: Customers and custom orders

**Files:**
- Modify: `resources/views/admin/customers/index.blade.php`
- Modify: `resources/views/staff/customers/index.blade.php`
- Modify: `resources/views/admin/customorders/index.blade.php`
- Modify: `resources/views/admin/customorders/customorder.blade.php`
- Modify: `resources/views/admin/customorders/modifyorder.blade.php`
- Test: `tests/Feature/AdminShellTest.php`

**Interfaces:**
- Consumes: `ui.page-header`, `ui.table-shell`, `ui.status-badge`, `ui.money`.
- Preserves: customer forms/modals; custom-order accept/decline/price/quantity forms; image uploads; progress values.

- [ ] **Step 1: Extend the test**

Assert admin customers and custom-order pages contain `table-shell`.

- [ ] **Step 2: Run to verify failure**

Run: `php artisan test --compact --filter=AdminShellTest`
Expected: FAIL.

- [ ] **Step 3: Convert**

Customers: page header, table shell, same columns and action buttons.

Custom orders: page header, table shell, status badges, money. Detail pages: page header cards, progress bar, payment and upload sections; keep every form action, field name, and `_method`.

- [ ] **Step 4: Verify**

Run filter test → PASS.
Manual: accept or decline a custom order in a local test record; change quantity and price in `modifyorder`; bank toggle and preview still work.

- [ ] **Step 5: Commit**

```bash
git add resources/views/admin/customers resources/views/staff/customers resources/views/admin/customorders tests/Feature/AdminShellTest.php public/build
git commit -m "feat(admin): convert customers and custom orders"
```

---

### Task 6: Cleanup and full verification

**Files:**
- Modify: any converted view with leftover inline colors.
- Test: full suite.

- [ ] **Step 1: Grep for leftovers**

Run: `grep -rn "anthonyterrien\|data-toggle=\|data-dismiss=\|btn-black\|blue-gradient\|small-box" resources/views/admin resources/views/staff`

Expected: no matches in converted pages. Phase-two pages may still show them; list them, do not convert.

- [ ] **Step 2: Full suite and build**

Run: `php artisan test --compact` → all tests pass.
Run: `npm run build` → passes.

- [ ] **Step 3: Rendered verification**

At 1274px and 390px: dashboard, orders, deliveries, items, low stock, customers, custom orders. Confirm no page overflow, DataTables controls work, status colors match, custom-order progress renders.

- [ ] **Step 4: Commit**

```bash
git add -A resources/views/admin resources/views/staff resources/sass/app.scss resources/js/app.js public/build
git commit -m "chore(admin): verify design system rollout"
```
