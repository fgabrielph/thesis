# Local restore notes

Branch: `restore/laravel10-sqlite`

## Stack

- Laravel 12.74
- PHP 8.2+ (tested with 8.3)
- SQLite
- Vite + AdminLTE 4 + Bootstrap 5 for admin/staff
- MDBootstrap for the customer storefront
- PayPal removed; checkout supports Cash on Delivery and Bank Transfer
- `trader_sma()` is a pure-PHP polyfill in `app/Support/trader_sma.php`; no PECL extension required
- `composer audit` and `npm audit` report no advisories

## First-time setup

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve --host=127.0.0.1 --port=8000
```

Committed Vite output lives in `public/build`, so a fresh clone runs without Node.

Rebuild admin/staff assets only when changing them:

```bash
npm ci
npm run build
```

Node 20.19+ or 22.12+ is required for the build. `node_modules` is ignored; `public/build` is committed intentionally for thesis portability.

The `DB_DATABASE` value in `.env` must be an absolute path to `database/database.sqlite`. Laravel falls back to `database/database.sqlite` when the variable is empty.

Required PHP extension for image uploads and thumbnails: `gd`.

## Demo accounts

| Role | URL | Email | Password |
|---|---|---|---|
| Admin | `/admin/login` | `admin@admin.com` | `password` |
| Staff | `/staff/login` | `staff@staff.com` | `password` |
| Customer | `/login` | `customer@example.com` | `password` |

The customer account is pre-verified. New registrations send a verification link to `storage/logs/laravel.log` because `MAIL_MAILER=log`.

## Seed data

`DemoDataSeeder` creates categories, brands, items, one customer, eight orders spread across 2020, and six custom orders. The spread gives the SMA forecast pages enough monthly data to render.

## Old MySQL dump

To restore the original phpMyAdmin dump later:

1. Import the dump into local MySQL.
2. Set `DB_CONNECTION=mysql` and the `DB_*` values in `.env`.
3. Run `php artisan config:clear`.

The application code does not use MySQL-specific SQL, so it also works on SQLite.
