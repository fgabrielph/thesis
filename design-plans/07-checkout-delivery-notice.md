# Show delivery terms at checkout

Status: implemented and verified
Written against: `ced3e5f`

## Evidence chain

- Surface: customer cart and checkout pages (`/cart`, `/checkout`).
- Problem: the cart states that delivery is free only within Metro Manila and that outside-Metro-Manila customers must contact the store. The checkout summary shows an unconditional total with no delivery term or fee, so the condition disappears at the point of payment.
- Design evidence: `resources/views/site/pages/cart.blade.php:122-124` renders the delivery notice; `resources/views/site/pages/checkout.blade.php:210-228` renders the summary and `Total (PHP)` with no delivery notice; `app/Http/Controllers/CheckoutController.php:42` sets `grand_total` from `Cart::total()` and adds no delivery charge. Same purchase task, contradictory delivery information.
- Owner: `resources/views/site/pages/cart.blade.php` and `resources/views/site/pages/checkout.blade.php`; the notice text has no shared owner today.
- Scope and affected surfaces: cart summary, checkout summary, both rendered from `resources/views/site/master.blade.php`.
- Uncertainty: the cart notice uses a 20px red bold italic treatment. It must be checked in the narrower checkout summary column at mobile width; if it overflows or dominates the summary, stop rather than restyle it inside this plan.

## Design decision

Make the existing delivery notice a single shared storefront partial and render it in both the cart summary and the checkout summary. Preserve the copy, link, and visual treatment verbatim so the cart page does not change and checkout states the same condition. Do not add a delivery fee, conditional logic, or new delivery copy.

## Reuse

- Existing notice markup and copy in `resources/views/site/pages/cart.blade.php:122-124`.
- Existing summary column composition in `resources/views/site/pages/checkout.blade.php:203-230`.
- Exemplar for storefront partials: `resources/views/site/includes/messages.blade.php`.

New primitive: `resources/views/site/includes/delivery-notice.blade.php`. The existing system cannot express this because the notice is inline copy owned by the cart page, and checkout has no equivalent. Two consumers need the same text: cart and checkout. A shared partial is the smallest owner that prevents the copy from diverging again.

## Changes

1. Create `resources/views/site/includes/delivery-notice.blade.php`
   - Change: move the paragraph currently at `resources/views/site/pages/cart.blade.php:122-124` into this partial unchanged, including `style="color: red; font-size: 20px"`, italic, bold, phone number `364-8556`, and `mailto:mjctrdgmfg@gmail.com` link.
   - Preserve: exact wording, including `metro manila` and `Shipping outside Metro Manila`.
   - Verify: partial renders the same markup the cart rendered before.

2. `resources/views/site/pages/cart.blade.php`
   - Change: replace the inline paragraph at lines 122-124 with `@include ('site.includes.delivery-notice')`.
   - Preserve: placement after the payment-method images, inside the summary column.
   - Verify: cart summary looks unchanged at desktop and mobile widths.

3. `resources/views/site/pages/checkout.blade.php`
   - Change: after the closing `</ul>` of the summary list (line 228) and before the summary column closes, add `@include ('site.includes.delivery-notice')`.
   - Preserve: item list, `Total (PHP)` row, column classes, and checkout form.
   - Verify: checkout summary shows the delivery notice under the total, with a working email link.

## Scope

- Inherit: `/cart` and `/checkout` for guest and authenticated customers.
- Verify: cart empty state (`/cart` with no items) does not include the notice; order confirmation and account pages are unaffected.
- Exclude: delivery fees, address-based conditions, payment-method-specific terms, copy edits, summary redesign, currency formatting.

## Validation

- Product: add an item, open `/cart`, confirm the notice is unchanged; proceed to `/checkout`, confirm the same notice appears under the total.
- Interface: `/cart` and `/checkout` at 375px and 1440px; notice does not overflow the summary column, and the mailto link is clickable.
- System: the notice copy exists once in `resources/views/site/includes/delivery-notice.blade.php`; no duplicated literal text remains.
- Repository: `php artisan test --compact` → 17 passed (41 assertions).

## Stop conditions

- Stop if the business wants delivery terms to vary by city, payment method, or order total; that is behavior, not presentation.
- Stop if the 20px red treatment overflows or dominates the checkout summary column; the owner must decide the checkout treatment before implementation continues.
- Stop if the notice wording is under legal review and must not be duplicated verbatim.

## Design documentation

- After acceptance and validation: record that storefront delivery terms live in one partial included by cart and checkout. Destination: project UI notes; no storefront design document exists today.
