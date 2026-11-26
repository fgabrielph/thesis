# Active sidebar state

Status: implemented and verified
Written against: working tree at `2773d1f`

## Evidence chain

- Surface: admin and staff authenticated shell, all pages.
- Problem: sidebar renders every menu link as neutral; current page is not indicated.
- Design evidence: AdminLTE 3 defines `.nav-sidebar .nav-link.active` and `.has-treeview.menu-open`; `public/css/app.css` contains those rules. `resources/views/admin/master.blade.php:20` always renders the sidebar; `resources/views/staff/master.blade.php` does the same.
- Owner: `resources/views/admin/includes/sidebar.blade.php`, `resources/views/staff/includes/sidebar.blade.php`.
- Scope and affected surfaces: every admin and staff page.
- Uncertainty: none.

## Design decision

Match each menu item to the current route with `request()->routeIs()`. Apply `active` to the matching link. Apply `menu-open` to a group whose child route is active.

## Reuse

- AdminLTE `nav-link active`
- AdminLTE `has-treeview menu-open`
- Exemplar: AdminLTE sidebar state classes in `public/css/app.css`

## Changes

1. `resources/views/admin/includes/sidebar.blade.php`
   - Change: add route-based `active` and `menu-open` classes to dashboard, orders, custom orders, deliveries, custom deliveries, accounts, inventory, reports, visualization, and logs.
   - Preserve: existing route targets, icons, labels, and group structure.
   - Verify: current page link has `active`; parent group has `menu-open`.
2. `resources/views/staff/includes/sidebar.blade.php`
   - Change: same treatment for dashboard, orders, deliveries, customer management, inventory, and walk-in.
   - Preserve: existing route targets, icons, and labels.
   - Verify: current page link has `active`; inventory group opens when a child is active.

## Scope

- Inherit: all admin and staff authenticated pages.
- Verify: login pages do not render the sidebar and are unaffected.
- Exclude: menu structure changes, new routes, staff color overrides.

## Validation

- Product: open each admin/staff section and confirm the matching link is highlighted.
- Interface: nested inventory and report groups, direct links, narrow viewport.
- System: only AdminLTE state classes are used; no new CSS.
- Repository: `php artisan test` → 2 passed.

## Stop conditions

- Stop if route names change or a menu item has no route.

## Design documentation

- After acceptance: record active-state convention in project UI notes. No design document exists today.
