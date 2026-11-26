# Storefront Design System Migration Design

Date: 2026-11-26
Status: approved for planning

## Goal

Move the customer storefront purchase flow onto Bootstrap 5 with one set of design tokens and shared Blade components, while admin and staff keep their AdminLTE 4 shell.

## Decisions

- Storefront shares tokens with admin, not chrome. It keeps its own black navbar and public-page layout.
- Orange is the primary action color. Black is the chrome. Purple gradients, mixed blue/green actions, and the 2019 MDB palette are retired.
- Content, routes, controllers, cart behavior, prices, tax, and order flow stay unchanged. Only structure, components, and styling change. Typos and duplicate labels may be fixed.
- First delivery boundary: home, shop, category, product, cart, checkout, confirmation. Account, orders, custom orders, invoice, policy, FAQ, and auth pages stay on the old layout for phase two.
- Two layouts coexist until phase two ends. Converted pages must not load MDB or jQuery.

## Architecture

New files:

- `resources/views/site/layouts/storefront.blade.php` — public shell: navbar, main container, flash area, footer.
- `resources/sass/storefront.scss` — Bootstrap 5 source import, token definitions, storefront component styles.
- `resources/js/storefront.js` — imports `storefront.scss`, Bootstrap 5 JS bundle, Font Awesome 6 CSS.
- `vite.config.js` — add `resources/js/storefront.js` as a second input.
- `resources/views/components/storefront/*` — anonymous Blade components.

Existing files kept:

- `resources/views/site/master.blade.php` and MDB/jQuery assets remain for unconverted pages.
- `resources/js/app.js` and admin/staff layouts untouched.
- `resources/views/site/includes/delivery-notice.blade.php` moves into the component directory; the old include path is removed after conversion.

Asset isolation: only `site.layouts.storefront` loads `@vite('resources/js/storefront.js')`. Only `site.master` loads the legacy MDB stack.

## Tokens

Defined in `resources/sass/storefront.scss`:

```scss
:root {
    --sf-brand: #ffa500;
    --sf-on-brand: #111111;
    --sf-ink: #111111;
    --sf-muted: #6b7280;
    --sf-surface: #ffffff;
    --sf-surface-alt: #f7f7f8;
    --sf-border: #e5e7eb;
    --sf-success: #15803d;
    --sf-danger: #b91c1c;
    --sf-radius-sm: 6px;
    --sf-radius-md: 10px;
    --sf-space-1: 0.25rem;
    --sf-space-2: 0.5rem;
    --sf-space-3: 1rem;
    --sf-space-4: 1.5rem;
    --sf-space-5: 2.5rem;
}
```

- Bootstrap primary is set to `#ffa500` at SCSS compile time. Text on brand uses `--sf-on-brand` for contrast.
- Headings use the Bootstrap system font stack; no new webfont dependency.
- Body text uses `--sf-ink`; muted text uses `--sf-muted`.
- Destructive actions use `--sf-danger`; success confirmations use `--sf-success`.
- Only these tokens may set color in storefront components. No inline hex values.

## Components

Anonymous Blade components under `resources/views/components/storefront/`, used as `<x-storefront.money ... />`.

| Component | Props | Renders |
| --- | --- | --- |
| `money` | `amount` | `₱ 1,234.00`, via `number_format($amount, 2)` |
| `product-card` | `item` | fixed-ratio image, name link, `money`, stock line, Buy action |
| `cart-modal` | `item` | quantity field, Buy Now, POST to `cart.store` |
| `form-field` | `name`, `label`, `value`, `type`, `required`, `error` | label, input, invalid feedback |
| `order-summary` | `items`, `total` | line items, total, delivery notice |
| `delivery-notice` | none | existing copy and contact link |
| `flash` | none | session success/error alerts |

Rules:

- One owner per component. Pages do not duplicate card, money, form-field, or summary markup.
- `product-card` links to `site.product` and opens `cart-modal`; it does not submit directly.
- `order-summary` is used by both cart and checkout; it never computes tax or fees.
- `form-field` is the only checkout field pattern: label above input, Bootstrap invalid state, `old()` values, error text.

## Page conversion

Order of work, each step independently shippable:

1. Shell, tokens, navbar, footer, flash, delivery notice, home page.
2. Shop and category pages: product cards, one shared modal per item, quote CTA.
3. Product page: money, stock, quantity form.
4. Cart: order summary, responsive item table, quantity update, remove.
5. Checkout: form-field, order-summary, delivery notice, Place order.
6. Confirmation page: money, order summary links, delivery notice.
7. Remove legacy asset links from converted pages only.

Unchanged in every step: route names, controller actions, `cart.store`/`cart.update` payloads, `Cart` totals, `NormalizeCartTax`, order creation, confirmation ownership check.

## Validation

- `php artisan test --compact` green after each step; all existing tests stay valid.
- New feature tests: `GET /`, `/shop`, `/shop/{category}`, `/product/{id}` return 200 and show at least one formatted price.
- Rendered checks at 1274px and 390px: `document.documentElement.scrollWidth == window.innerWidth`, card CTAs aligned per row, no clipped prices.
- DOM check on converted pages: no `jquery`, no `mdb` script or stylesheet requests.
- One money format across cards, product, cart, checkout, confirmation.
- `npm run build` passes before merge.

## Risks

- Bootstrap 5 interactions are not covered by PHPUnit. Each step requires a manual modal, dropdown, and mobile-nav check.
- Two layouts coexist. Shared partials must remain layout-neutral; storefront components must not be included from `site.master`.
- Account pages still use jQuery and DataTables; they must not receive the new layout until phase two.
- Demo images vary in shape; product-card containers must enforce a fixed ratio.
- Cart session data and pricing rules must not change during the visual migration.

## Phase two

Convert account, orders, custom orders, invoice, policy, FAQ, and auth pages. Then remove `site.master`, MDB assets, jQuery, and the remaining legacy scripts. Deploy note stays: `npm run build` and `php artisan config:cache` after release.

## Out of scope

- Checkout fee or shipping logic.
- New payment methods.
- Product search, filtering, or wishlist features.
- Admin/staff shell changes.
- Brand logo redesign.
