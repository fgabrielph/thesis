# Session handoff — 2026-11-26

## State

- Branch: `master`, clean, pushed.
- Head at handoff start: `a932c48` (merge of storefront design system).
- Laravel 13.44.1, PHP 8.3.37, Bootstrap 5.3.9, PHPUnit 12.
- Tests: 31 passed (95 assertions).

## Completed today

1. Upgraded Laravel 12 → 13.44.1; `hardevine/shoppingcart` replaced by source-identical `redx1t/shoppingcart`.
2. Cart tax: removed accidental 21% package default; added legacy-cart normalization middleware.
3. Cart price integrity: server-side item price, checkout blocks changed price or low stock.
4. Storefront: delivery terms shared between cart, checkout, confirmation.
5. Shop/category: prices, stock, mobile overflow, category height, card alignment.
6. Checkout: unified fields, receiver copy, order confirmation page, navbar logo fix.
7. Storefront polish: footer year/link, active nav, fixed image ratios, removed hidden price inputs.
8. Admin/staff: inventory naming, low-stock copy, dashboard link labels, Confirmed badge contrast, peso prices.
9. Storefront design system migration, phase one: Bootstrap 5 shell + Vite entry, tokens, shared components; converted home, shop, category, product, cart, checkout, confirmation. Account/policy pages still on legacy `site.master`.
10. Admin/staff rendered audit completed.

Spec: `docs/superpowers/specs/2026-11-26-storefront-design-system-design.md`
Plan: `docs/superpowers/plans/2026-11-26-storefront-design-system.md`

## Next session

Storefront design system, phase two:

- Convert account, orders, custom orders, invoice, policy, FAQ, and auth pages to `site.layouts.storefront`.
- Reuse existing components: `money`, `form-field`, `order-summary`, `flash`, `delivery-notice`.
- Then delete MDB 4, jQuery 3.4.1, `resources/views/site/master.blade.php`, and unused `site/includes/*`.

## Deploy checklist

- `npm run build`
- `php artisan config:cache` — a cache built before the tax fix keeps `cart.tax` at 21.

## Notes

- Admin/staff use AdminLTE 4 / Bootstrap 5 via `resources/js/app.js`; do not change.
- Storefront Vite entry: `resources/js/storefront.js` + `resources/sass/storefront.scss`.
- `tests/TestCase.php` calls `withoutVite()`.
- Deferred minor: checkout form no longer sets `enctype` (no file inputs).
- Deferred minor: cart no longer redirects in-view on quantity over stock; checkout validates stock.
