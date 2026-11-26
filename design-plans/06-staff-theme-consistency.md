# Staff shell theme consistency

Status: implemented and verified
Written against: working tree at `2773d1f`

## Evidence chain

- Surface: staff navbar and sidebar.
- Problem: staff shell hardcodes dark red backgrounds and white text on every link, while admin uses the stock AdminLTE dark-primary sidebar and white navbar. Same component family, two visual systems.
- Design evidence: `resources/views/staff/includes/sidebar.blade.php:2,4,18,26-76` and `resources/views/staff/includes/navbar.blade.php:2,6,26,29-30` use inline `background-color: darkred` and `color: white`. Admin equivalents use `sidebar-dark-primary` and `navbar-white navbar-light` with no inline colors.
- Owner: staff navbar and sidebar partials.
- Scope and affected surfaces: all staff authenticated pages.
- Uncertainty: the red may have been an intentional role cue. User selected consistency with admin.

## Design decision

Remove the inline dark-red and white overrides. Use the same AdminLTE theme classes as the admin shell. Keep the staff menu structure and active-state logic.

## Reuse

- Admin `sidebar-dark-primary` sidebar.
- Admin `navbar-white navbar-light` navbar.
- AdminLTE active and menu-open state classes.

## Changes

1. `resources/views/staff/includes/sidebar.blade.php`
   - Change: remove `background-color: darkred` and every `color: white` inline style; point brand link to `staff.dashboard`.
   - Preserve: menu items, icons, labels, route-based active state.
   - Verify: sidebar matches admin colors.
2. `resources/views/staff/includes/navbar.blade.php`
   - Change: remove dark-red background and white text overrides; use `navbar-white navbar-light`; keep logout dropdown.
   - Preserve: pushmenu toggle and route links.
   - Verify: navbar matches admin.

## Scope

- Inherit: all staff pages.
- Verify: login page is unaffected.
- Exclude: admin shell, site theme, role-specific badges.

## Validation

- Product: compare staff and admin shells side by side.
- Interface: active menu item, open inventory group, logout dropdown.
- System: no inline theme colors remain in staff shell.
- Repository: `php artisan test` → 2 passed.

## Stop conditions

- Stop if the product owner wants staff red as an intentional role distinction.

## Design documentation

- After acceptance: record that admin and staff share the AdminLTE shell.
