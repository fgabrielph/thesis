# DataTables Bootstrap 4 integration

Status: implemented and verified
Written against: working tree at `2773d1f`

## Evidence chain

- Surface: admin and staff list pages using DataTables.
- Problem: table search box, length selector, pagination, and info text use DataTables default styling, not AdminLTE/Bootstrap 4. The search input appears visually detached from the card.
- Design evidence: `resources/views/admin/master.blade.php:13` and `resources/views/staff/master.blade.php:13` load `jquery.dataTables.css`; `resources/js/app.js` imports plain `datatables.net`; `package.json:29-30` uses `datatables.net-dt`. AdminLTE 3 is built on Bootstrap 4 (`public/css/app.css`), so the default DataTables skin contradicts the governing theme.
- Owner: both master layouts.
- Scope and affected surfaces: every table initialized by `#orderTable`, `#defTable`, `#atkTable`.
- Uncertainty: none; the user reported the visual mismatch.

## Design decision

Use DataTables' Bootstrap 4 integration while keeping the existing DataTables 1.10.20 core bundled in `public/js/app.js`. Load the matching Bootstrap 4 stylesheet instead of the default stylesheet, and load the Bootstrap 4 integration script after the core bundle.

## Reuse

- Existing DataTables core 1.10.20 in `public/js/app.js`
- Existing AdminLTE/Bootstrap 4 card, input, and pagination classes
- Exemplar: AdminLTE 3 DataTables plugin markup

## Changes

1. `resources/views/admin/master.blade.php`
   - Change: replace `jquery.dataTables.css` with `dataTables.bootstrap4.min.css`; add `dataTables.bootstrap4.min.js` after `js/app.js`.
   - Preserve: `stateSave` and ordering options, table IDs, existing scripts.
   - Verify: search, length selector, info, and pagination match Bootstrap 4.
2. `resources/views/staff/master.blade.php`
   - Change: same replacement and script addition.
   - Preserve: same initialization behavior.

## Scope

- Inherit: all admin and staff DataTables.
- Verify: pages without DataTables are unaffected.
- Exclude: table markup refactor, responsive wrapper, server-side processing.

## Validation

- Product: search and paginate an order table.
- Interface: desktop and narrow viewport; search input alignment; pagination active state.
- System: core DataTables version stays 1.10.20; no duplicate core loads.
- Repository: `php artisan test` → 2 passed.

## Stop conditions

- Stop if the CDN version does not match the bundled core version.

## Design documentation

- After acceptance: none.
