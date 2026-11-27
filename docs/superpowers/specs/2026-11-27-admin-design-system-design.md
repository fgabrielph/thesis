# Admin Design System Design

Date: 2026-11-27
Status: approved for planning

## Goal

Give admin and staff one consistent design system: shared tokens, shared Blade components, and consistent page patterns, without changing routes, permissions, or operator workflows.

## Decisions

- Admin adopts the storefront identity: orange `#ffa500` primary actions, near-black chrome, neutral surfaces. Admin keeps its dark sidebar and dense layout.
- Admin and staff keep separate layouts for role-specific menus. They share one component set.
- Workflows are preserved: same routes, table columns, form fields, filters, and actions. Broken UI is fixed; no new features.
- First delivery boundary: dashboard, orders, deliveries, inventory, customers, custom orders. Reports, logs, visualization, categories, brands, and staff management follow in phase two.
- "Shell" means the persistent frame: layout, navbar, sidebar, footer, flash area, content container. Page content is converted separately.

## Architecture

### Tokens

`resources/sass/app.scss` loads after AdminLTE CSS, so its rules win.

```scss
:root {
    --admin-brand: #ffa500;
    --admin-on-brand: #111111;
    --admin-ink: #111111;
    --admin-muted: #6b7280;
    --admin-surface: #ffffff;
    --admin-surface-alt: #f3f4f6;
    --admin-border: #e5e7eb;
    --admin-success: #15803d;
    --admin-warning: #b45309;
    --admin-danger: #b91c1c;
}
```

- Map `.btn-primary`, links, focus rings, and active sidebar items to the brand token.
- Sidebar remains dark; navbar remains AdminLTE white/light.
- Status badges keep semantic tones: success, warning, danger, secondary, info.
- No inline hex values in converted views.

### Shared components

Under `resources/views/components/ui/`, used by admin and staff:

| Component | Props | Purpose |
| --- | --- | --- |
| `page-header` | `title`, `subtitle` | Title row with action slot |
| `stat-card` | `label`, `value`, `href`, `icon`, `tone` | Dashboard metric card |
| `status-badge` | `status` | One status-to-tone mapping |
| `table-shell` | `title`, `empty`, `emptyMessage` | Card, responsive wrapper, toolbar slot, empty row |
| `form-field` | `name`, `label`, `value`, `type`, `required` | Label, input, invalid feedback |
| `empty-state` | `message` | Icon, message, action slot |
| `money` | `amount` | `₱ 1,234.00` |

Rules:

- `status-badge` owns the only status color mapping.
- `table-shell` keeps existing table ids `orderTable`, `defTable`, `atkTable` so DataTables continues to initialise.
- `form-field` merges extra HTML attributes.

### Shell changes

- `admin/master.blade.php` and `staff/master.blade.php` stay separate.
- Body carries `data-admin-shell` or `data-staff-shell`.
- Navbar, sidebar, footer stay structurally the same; only tokens and active-state colors change.
- `resources/js/app.js` gains vanilla handlers for admin custom-order bank toggle and image preview. The external `http://anthonyterrien.com/...jquery.knob.min.js` script is removed.

### Custom-order progress

The jQuery knob dial is replaced by a Bootstrap progress bar computed from `completed / quantity`, with the same text labels. No new data.

## Conversion order

1. Tokens, shared components, shell polish, custom-order progress and vanilla handlers.
2. Dashboard: `stat-card` replaces the four small boxes; same counts and links.
3. Orders and deliveries: `page-header`, `status-badge`, `table-shell`; same columns and actions.
4. Inventory: items and low-stock tables on `table-shell`; same modals and DataTables.
5. Customers and custom orders: same treatment; custom-order progress bars.
6. Cleanup and full verification.

Every page is converted in both admin and staff where the counterpart exists.

## Validation

- Existing tests stay green.
- New tests: `data-admin-shell` and `stat-card` on admin dashboard; `data-staff-shell` on staff dashboard; `status-badge` on orders; `table-shell` on items.
- Each page rendered at 1274px and 390px: table scroll inside card, no page overflow.
- Status mapping checked for Pending, Confirmed, On Delivery, Completed, Return, Declined, Paid, Unpaid.
- One money format across dashboards, orders, and inventory.
- `npm run build` passes after each task.

## Risks

- AdminLTE uses compiled CSS. Some components need scoped overrides rather than variable changes.
- DataTables is initialised globally in the layout for three table ids. Markup changes must preserve ids and `thead` structure.
- Admin and staff templates are separate; components are shared, but conversion happens twice.
- Unconverted phase-two pages will look slightly older than converted pages until phase two ships.

## Phase two

Reports, logs, visualization, categories, brands, staff management, and remaining staff pages. Then remove any leftover page-local styles.

## Out of scope

- Permission or role changes.
- New reports, filters, or workflow steps.
- Chart.js redesign on the dashboard.
- Storefront changes.
- Admin branding or logo redesign.
