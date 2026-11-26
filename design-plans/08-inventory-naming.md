# Align inventory page naming

Status: implemented and verified
Written against: `3f8da3a`

## Evidence chain

- Surface: admin items page (`/admin/items`) and staff items page (`/staff/staff_items`).
- Problem: one page names the same records three ways. Browser title reads `Item`, page heading reads `Items`, table header reads `Product ID`.
- Design evidence: `resources/views/admin/items/index.blade.php:3` and `resources/views/staff/items/index.blade.php:3` set `@section('title') Item`; both files use `<th>Product ID</th>` at line 44; both render the heading `Items`; `design-plans/03-inventory-terminology.md` records the decision to use `Items` for inventory records.
- Owner: `resources/views/admin/items/index.blade.php` and `resources/views/staff/items/index.blade.php`. The two files are 506-line near-duplicates differing only in layout, messages include, and two controller actions.
- Scope and affected surfaces: admin items page, staff items page, both rendered by their respective master layouts.
- Uncertainty: none.

## Design decision

Use the already-documented `Items` vocabulary for the page title and table identifier column. The page title becomes `Items`; the table header becomes `Item ID`. Leave the heading, subtitle, routes, controllers, and table behavior unchanged.

## Reuse

- Documented vocabulary `Items` from `design-plans/03-inventory-terminology.md`.
- Existing page heading `<h1>Items</h1>` in both files as the canonical label.
- Existing table structure and DataTables initialization.

## Changes

1. `resources/views/admin/items/index.blade.php`
   - Change: `@section ('title') Item @endsection` → `@section ('title') Items @endsection`.
   - Change: `<th class="text-center">Product ID</th>` → `<th class="text-center">Item ID</th>`.
   - Preserve: heading, subtitle, routes, filters, modals, actions.
   - Verify: browser title shows `... | Items`; first column header reads `Item ID`.

2. `resources/views/staff/items/index.blade.php`
   - Change: same two string replacements.
   - Preserve: same structure and staff controller actions.
   - Verify: same result on `/staff/staff_items`.

## Scope

- Inherit: admin and staff items list pages.
- Verify: sorting on the identifier column still works; DataTables search and pagination unchanged; item modals unaffected.
- Exclude: shared partial extraction, subtitle copy, other pages, route or model renames, currency formatting.

## Validation

- Product: open both items pages; title tag and first column use the new terms.
- Interface: desktop and 390px; table still scrolls inside the card; no layout shift.
- System: one term per record; no remaining `Product ID` in either items view.
- Repository: `grep -rn "Product ID" resources/views/admin/items resources/views/staff/items` → no matches; `php artisan test --compact` → 26 passed (69 assertions).

## Stop conditions

- Stop if another page or report relies on `Product ID` as a stable label; update it in the same change instead of leaving two terms.
- Stop if the DataTables column configuration targets the header text rather than the column index.

## Design documentation

- After acceptance and validation: record `Items` / `Item ID` as the canonical inventory terms in the project UI notes. Destination: extend `design-plans/03-inventory-terminology.md`; no storefront design document exists.
