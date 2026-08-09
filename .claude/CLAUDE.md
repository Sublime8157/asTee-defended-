# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

asTee — a Laravel 10 t-shirt e-commerce store with a customer storefront, a separate admin panel, and a fabric.js-based "DIY" shirt designer. Blade + Tailwind/Flowbite, MySQL.

## Commands

```bash
php artisan serve            # dev server (expects MySQL `asTeeFinal` per .env)
npm run dev                  # Vite dev server for resources/css/app.css + resources/js/app.js
npm run build                # production assets
vendor/bin/phpunit           # full suite
vendor/bin/phpunit --filter testMethodName        # single test
vendor/bin/phpunit tests/Feature/ExampleTest.php  # single file
vendor/bin/pint              # formatter (Laravel Pint)
php artisan migrate:fresh --seed
```

Only the stock `ExampleTest`s exist. `phpunit.xml` has the sqlite in-memory env lines **commented out**, so tests run against the real MySQL database in `.env` — uncomment them before writing tests that touch the DB.

`webpack.mix.js` is vestigial: laravel-mix is not installed. Everything in `public/js/` (`adminScripts.js`, `cart.js`, `diy.js`, `filter.js`, …) is hand-written and loaded with plain `<script src>` tags from Blade — it is not part of any build. Vite only handles `resources/css/app.css` and `resources/js/app.js`.

## Architecture

### Two independent auth systems

- **Customers** use Laravel's `Auth` (`User` model → `customers` table), but `LoginSignupController::process` *also* stuffs `isLoggedin`, `id`, `username`, `profile`, `verification` into the session. Blade views and the `cart` middleware read those session keys, not `Auth::check()`. Changing one without the other breaks pages silently.
- **Admins** do not use Laravel Auth at all. `adminIndexController` checks the `adminLogin` model manually and sets an `adminLoggedIn` session flag; the `admin` middleware alias only asserts that flag exists. There is no role column, no guard, no gate.
- Blocked/pending users are expressed via `customers.userStatus` (2 = blocked) and `verification` (valid-ID review), checked inline at login.
- Email verification is custom and **unsigned**: `/emailVerified/{email}` and `/verifyAdmin/{email}` set `email_verified_at` for whatever email is in the URL.

### Product lifecycle = separate tables, not a status column

A product physically moves between tables as it progresses; each move copies the row and deletes the original:

```
product_on_hand (OnHand)  →  product_on_process (Processing)  →  sales (Sales)
                                       ↓
                          product_on_cancel (CancelReturn)
```

Each stage has its own controller (`adminOnHandsController`, `adminOnProcessController`, `adminCancelReturnController`) with near-identical `moveProduct` / `moveMultiple` / `removeMultiple` / `sortProduct` / `filterDate` methods. A change to move semantics usually needs to be made in all three.

`products` (the `Products` model) is the customer-facing catalog and is distinct from `product_on_hand`, which drives both the admin inventory tab and the storefront listing/cart (`UserController::cart` looks items up in `OnHand`).

### Traits carry the shared logic

- `app/Traits/Filter.php` / `FilterUser.php` — generic `sortTrait($request, $model, $view)`, `displayTrait`, `filterDateTrait` used by the admin list screens; they take a model class and a view name and return a rendered view.
- `app/Traits/Types.php` — `producStats()` and `variationType()` map integer codes to labels **hardcoded in switch statements** (variation 1 = Couple Shirt, 2 = Solo, 3 = Family, 4 = Kids; productStatus 0–5 = On Hand → To Cancel). The `variations`/`status` tables exist but these switches are what views actually display, so adding a variation means editing the trait too.

### Conventions in this codebase (inconsistent by history)

- Model class names are mixed case: `OnHand`, `Processing` vs `cart`, `orders`, `customers`, `feedback`, `adminLogin`, `payment_history`. Controller names likewise (`UserController` vs `accountsController`).
- `$table` rarely matches Laravel convention — always check the model (`User` → `customers`, `OnHand` → `product_on_hand`).
- Every route lives in `routes/web.php`, ungrouped; `middleware('admin')` is applied per-route on the admin *page* routes only — most admin POST/PATCH/DELETE action routes are **unprotected**. `Auth::routes()` is called twice.
- `u763116450_asTeeFinal.sql` is the authoritative production schema dump; `database/migrations/` is incomplete relative to it.

### Mail

`app/Mail/` holds Mailables sent synchronously (`Mail::to(...)->send(...)`) inside controller actions — no queue. Templates live in `resources/views/emails/` and `resources/views/mail/`, several of which are also exposed as plain preview routes (`/invoice`, `/newOrder`, `/feedback`).
