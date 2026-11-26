# Replace footer template placeholder

Status: implemented and verified
Written against: working tree at `2773d1f`

## Evidence chain

- Surface: admin and staff footer, all authenticated pages.
- Problem: footer right side reads `Anything you want`; left side shows `Copyright © 2014-2019`.
- Design evidence: `resources/views/admin/includes/footer.blade.php:15` and `resources/views/staff/includes/footer.blade.php:18` are rendered by both master layouts on every page.
- Owner: both footer partials.
- Scope and affected surfaces: all admin and staff pages.
- Uncertainty: none.

## Design decision

Replace the placeholder with the product name. Keep the existing footer structure and AdminLTE styling. Update the stale copyright range to start at the thesis year (2020) and end at the current year.

## Reuse

- Existing `.main-footer` layout.
- Existing `config('app.name')`.
- Exemplar: `resources/views/admin/includes/footer.blade.php`

## Changes

1. `resources/views/admin/includes/footer.blade.php`
   - Change: right text becomes `Order and Delivery Management System`; copyright becomes `2020-{{ date('Y') }}`.
   - Preserve: link to `route('home')`, brand `NEW MJC`, footer classes.
   - Verify: no placeholder text remains.
2. `resources/views/staff/includes/footer.blade.php`
   - Change: same text and copyright update.
   - Preserve: structure and classes.

## Scope

- Inherit: all admin and staff pages.
- Verify: login pages do not include the footer.
- Exclude: site footer.

## Validation

- Product: footer shows real product information on dashboard and list pages.
- Interface: desktop and mobile footer layout.
- System: no duplicated hardcoded product name outside `config('app.name')`.
- Repository: `php artisan test` → 2 passed.

## Stop conditions

- Stop if the product name differs from `config('app.name')`.

## Design documentation

- After acceptance: none.
