# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

asTee — a Laravel 12 t-shirt e-commerce store with a customer storefront, a separate admin panel,
and a fabric.js-based "DIY" shirt designer. Blade + Tailwind/Flowbite, MySQL/MariaDB.

It began as a capstone project and is being taken to business-ready in phases. The working plan is
[plan.md](plan.md); per-phase notes are in the `Phase N/` folders and indexed by
[progress.md](progress.md). **Phases 0–3 are done. Phase 4 (checkout & PayMongo) is next.**
Conventions in [checklist.md](checklist.md) apply: a PR per feature, a commit per task, and every
change logged to `refactor.md` / `featured.md` / `deleted.md` / `progress.md` with the reasoning
for choosing A over B.

## Commands

```bash
docker compose up -d          # app on :8000, MariaDB 10.11 on 127.0.0.1:3306
php artisan serve             # or run against the containerised DB directly
npm run dev                   # Vite for resources/css/app.css + resources/js/app.js
npm run build                 # production assets
vendor/bin/phpunit            # full suite
vendor/bin/pint               # formatter
php artisan migrate:fresh --seed
php artisan astee:make-admin  # the only way to create an admin account
```

Seeded logins after `migrate:fresh --seed`: admin `owner` / customer `demo`, both `Password123!`.

`phpunit.xml` uses in-memory SQLite. **`pdo_sqlite` is commented out in this machine's
`C:\php\php.ini`**, so the suite cannot open that connection locally — either uncomment
`extension=pdo_sqlite`, or run against the container:

```bash
DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_DATABASE=astee_test DB_USERNAME=astee DB_PASSWORD=secret vendor/bin/phpunit
```

Everything in `public/js/` (`adminScripts.js`, `cart.js`, `diy.js`, `filter.js`, …) is hand-written
and loaded with plain `<script src>` tags from Blade — it is not part of any build. Vite only
handles `resources/css/app.css` and `resources/js/app.js`. Phase 6 changes this.

## Architecture

### Two auth guards, one identity source each

- **Customers** — the `web` guard, `App\Models\User` → `customers` table. Read the guard
  (`Auth::user()`, `auth()->check()`), never session keys. The old parallel session system
  (`isLoggedin`, `id`, `username`, `profile`, `verification`) was removed in Phase 3.
- **Admins** — the `admin` guard, `App\Models\AdminUser` → `admin_users`. The `admin` middleware
  asserts `Auth::guard('admin')->check()`. There is no web registration; use `astee:make-admin`.
- Blocked and ID-verified state are nullable timestamps on `customers` (`blocked_at`,
  `id_verified_at`) with `isBlocked()` / `hasVerifiedId()` helpers — not status integers.
- Email verification uses Laravel's `signed` middleware.

### The order lifecycle is a status column

```
products (catalog, has stock)
    └─ cart_items ─► orders ─► order_items.status
                                  to_pay → to_ship → to_receive → to_review → completed
                                                  └─────────────────────────► cancelled
```

There is **one row per order line for its whole life**. Until Phase 3 a line was physically copied
between `product_on_hand`, `product_on_process` and `product_on_return_cancel` and deleted from the
previous table, which is why three controllers held near-identical `moveProduct` / `moveMultiple`
code that had drifted apart. Do not reintroduce a table per state.

- `AdminProductController` owns the catalog. `AdminOrderItemController` owns order lines; its
  Processing and Cancel/Return screens are the same query with a different status filter.
- `order_items` snapshots description, image, variation, gender, size and price at purchase.
  Editing or deleting a catalog product must never rewrite what a customer bought.
- A sale is `Order::paid()` — `whereNotNull('paid_at')`. There is no `sales` table.

### Money is server-authoritative

**All order pricing goes through `app/Services/OrderService.php`.** The request carries product
ids, an address, a contact and a payment method — never money. Prices are read from
`products.price` inside a `DB::transaction` with `lockForUpdate` on the rows being sold.

If you add a checkout path, call `place()` (from the cart) or `placeFor()` (product id => quantity).
Do not price anything in a controller, and do not accept a price, subtotal or total from a request.
`tests/Feature/CheckoutPricingTest.php` fails if that regresses.

Money columns are `decimal(12,2)` with `decimal:2` casts.

### Enums, not lookup tables

`app/Enums/` holds `Variation`, `Gender`, `ShirtSize`, `OrderStatus` and `CancelReason` as
string-backed enums, cast on the models. `Enum::options()` renders every `<select>`; validate with
`Rule::enum(...)`. The lookup tables and `app/Traits/Types.php` are gone — when adding a case, the
enum is the only place to edit.

### Private files

Government IDs and payment proofs go to the `private` disk (`storage/app/private`) with hashed
names via `->store()`, and are read only through `AdminFileController` behind the admin guard. Both
routes take a record id, not a path. Never `storeAs($clientOriginalName)`, never the `public` disk,
and `svg` is not an accepted image type anywhere.

### Traits

- `app/Traits/SortsQueries.php` — `applySort()` with a column whitelist. Every list screen sorts by
  a user-supplied column name; use this rather than passing input to `orderBy()`.
- `app/Traits/FilterUser.php` — shared list/search/sort for the three account screens. Its scope is
  a closure, so each controller states its own `where`.

### Routes

`routes/web.php` is grouped by who may reach it: public, `auth` (customers), `admin`. Every
mutating route sits inside a group. Customer routes never take a user id in the URI — the owner
comes from the guard. `tests/Feature/RouteProtectionTest.php` walks the live route table, so a new
route added outside a group fails the suite.

### Mail

`app/Mail/` holds Mailables sent synchronously inside controller actions. Checkout mail is wrapped
in a try/catch because the order is already committed by then. Internal recipients come from
`config('mail.inboxes.*')`. **Phase 4 moves these to `ShouldQueue` on the `database` driver** —
the `jobs` table already exists.

### Conventions still inconsistent by history

Controller class names are mixed case (`UserController` vs `productsController` vs
`accountsController`). New controllers use StudlyCase. Views still carry the
`@extends('components.header')` + `<x-header/>` double-`<head>` bug on ~25 pages; Phase 6 owns the
layout rewrite, so don't fix it piecemeal.
