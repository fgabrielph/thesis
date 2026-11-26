# Narrow-screen table scrolling

Status: implemented and verified
Written against: working tree at `2773d1f`

## Evidence chain

- Surface: admin and staff list pages with wide tables.
- Problem: at narrow widths, tables overflow the card and page instead of scrolling inside the content area. Only 2 of 36 web tables use a responsive wrapper.
- Design evidence: AdminLTE 3 and Bootstrap 4 cards constrain body width; `.table` keeps its intrinsic width. The user reported the mobile overflow.
- Owner: shared admin/staff master layouts.
- Scope and affected surfaces: all authenticated list pages below 1200px.
- Uncertainty: none.

## Design decision

Add one shared stylesheet loaded by both shells. At widths below 1200px, make the card body scroll horizontally. Limit the rule to narrow screens so desktop dropdowns and table actions are not clipped.

## Reuse

- Existing `.content-wrapper`, `.card-body`, and `.table` structure.
- Bootstrap 4 responsive breakpoint `991.98px`.

## Changes

1. Create `public/css/admin-fixes.css`
   - Change: `@media (max-width: 1199.98px) { .content-wrapper .card-body { overflow-x: auto; -webkit-overflow-scrolling: touch; } }` and keep table headers on one line.
   - Preserve: desktop layout and dropdown behavior.
   - Verify: tables scroll horizontally on a narrow viewport.
2. `resources/views/admin/master.blade.php`
   - Change: load `admin-fixes.css` after `app.css`.
   - Preserve: existing asset order and DataTables assets.
3. `resources/views/staff/master.blade.php`
   - Change: same stylesheet link.
   - Preserve: existing assets.

## Scope

- Inherit: all admin and staff pages.
- Verify: desktop 1440px unchanged; mobile 485px table scrolls.
- Exclude: per-table markup rewrites, DataTables Responsive extension.

## Validation

- Product: view orders/items on a narrow viewport and scroll the table.
- Interface: 485px and 991px widths; dropdown actions still usable on desktop.
- System: single shared stylesheet, no duplicate rules.
- Repository: `php artisan test` → 2 passed.

## Stop conditions

- Stop if the rule clips dropdown menus at desktop widths.

## Design documentation

- After acceptance: none.
