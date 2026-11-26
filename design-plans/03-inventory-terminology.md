# Align inventory terminology

Status: implemented and verified
Written against: working tree at `2773d1f`

## Evidence chain

- Surface: admin and staff sidebar inventory group; admin items page.
- Problem: menu says `Products`; the destination page is titled `Item`; reports say `List of Items`.
- Design evidence: `resources/views/admin/includes/sidebar.blade.php:96`, `resources/views/admin/items/index.blade.php:3`, `resources/views/admin/includes/sidebar.blade.php:110`, `resources/views/staff/includes/sidebar.blade.php:70`.
- Owner: both sidebars.
- Scope and affected surfaces: inventory navigation in admin and staff.
- Uncertainty: none.

## Design decision

Use `Items` everywhere the inventory records are named in navigation. This matches the model, page title, and report vocabulary.

## Reuse

- Existing menu item structure.
- Existing page vocabulary `Item` / `List of Items`.

## Changes

1. `resources/views/admin/includes/sidebar.blade.php`
   - Change: `Products` → `Items`.
   - Preserve: route `items.index`, icon, group.
   - Verify: menu label matches page title.
2. `resources/views/staff/includes/sidebar.blade.php`
   - Change: `Products` → `Items`.
   - Preserve: route `staff_items.index`, icon, group.
   - Verify: menu label matches page title.

## Scope

- Inherit: admin and staff inventory navigation.
- Verify: reports keep `List of Items`.
- Exclude: model, table, and route renames.

## Validation

- Product: open inventory from each sidebar; terminology is consistent.
- Interface: expanded inventory group.
- System: no route or model change.
- Repository: `php artisan test` → 2 passed.

## Stop conditions

- Stop if the product owner prefers `Products` as the canonical term; then change page and report copy instead.

## Design documentation

- After acceptance: none.
