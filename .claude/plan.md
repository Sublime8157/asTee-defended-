# asTee — Capstone → Business-Ready

> Working plan. Conventions in [checklist.md](checklist.md) apply: PR per feature, separate commit per task,
> and every change logged to [refactor.md](refactor.md), [featured.md](featured.md), [deleted.md](deleted.md),
> [progress.md](progress.md). Decisions record *why A over B*.

## Context

`C:\Projects\AsTee` is a Laravel 10.50.2 t-shirt e-commerce capstone. It works as a demo. It cannot be operated as a business, for reasons that are not stylistic:

- **48 of 51 state-mutating routes have no auth middleware.** `middleware('admin')` guards 8 GET display pages only. Every admin write — create/edit/delete product, block/delete a customer, approve an ID, delete payment records — is reachable by an anonymous visitor who knows the URI (`routes/web.php`).
- **Anyone can become an admin.** `POST /submitRegistration` (`routes/web.php:35`) is unauthenticated, and `GET /verifyAdmin/{email}` (`routes/web.php:37`) sets `email_verified_at` for any address with no token or signature. Two requests → full admin panel.
- **Order totals are computed in the browser.** `public/js/cart.js:98` sums the total, it travels in a GET query string, `checkout.blade.php:88,91,97` renders it into *editable text inputs*, and `UserController.php:231` writes `$request->total` to the database — a field absent from the validation rules entirely. Per-line `price` is a hidden input validated only as `numeric`, never compared to `product_on_hand.price`. A customer checks out at any price they type.
- **Government ID scans and bank payment proofs are public.** Stored under `storage/app/public/images/` with the uploader's own filename (`userProfileController.php:107`), served by the web server with no authorization.
- **`u763116450_asTeeFinal.sql` is committed and contains real customer PII** — full names, home addresses, phone numbers, emails, bcrypt hashes.
- Migrations don't reproduce the schema (`orders.total`, `orders.paid`, the whole `payment_history` table are missing); `migrate:fresh` yields a database the app can't run against. Zero Eloquent relationships and zero DB transactions exist in `app/`.
- The DIY designer — the flagship feature — ends in a PNG download and a link to Facebook Messenger. It never touches the cart and generates no order.
- 25 pages emit a duplicate `<!DOCTYPE html><head>` after `</html>` (`@extends('components.header')` + `<x-header/>`). `theme.extend` in `tailwind.config.js` is empty; there are no brand tokens. The admin panel shows "Not Availble for Mobile Devices" below `lg:`.

**Outcome:** a Laravel 12 storefront with unified auth, server-authoritative money, a real PH payment gateway, the DIY designer as an orderable product, and a coherent apparel-industry UI.

**Scope note:** this is rebuild-scale — roughly 60–70% of `app/` is rewritten. Phases are ordered so each one leaves the app runnable. Phases 0–2 are the ones that matter if work ever stops early.

### Decisions taken up front

| Decision | Chosen | Why not the alternative |
|---|---|---|
| Payments | Real PH gateway (PayMongo) | Manual proof-of-payment means an admin eyeballs a screenshot to confirm money moved. Not operable at volume, and the amount is unverifiable. |
| DIY designer | Real orderable product | Today it produces a PNG download and a Messenger link — zero revenue flows through the system it's the flagship of. |
| Schema | Clean rebuild | Reconciliation migrations would inherit `int` money columns, a JSON `orders.productId` with no FK, and 7 dead lookup tables. Live data is capstone test records. |
| Framework | Laravel 12 | L10 is past security-fix EOL. The middleware/route layer is being rewritten in Phase 2 anyway — deferring the upgrade means doing that work twice. |

---

## Phase 0 — Repo hygiene & exposure

| Action | Target |
|---|---|
| Purge from git history (`git filter-repo`), add to `.gitignore` | `u763116450_asTeeFinal.sql` (PII), `public/public.zip` (9.9 MB), `composer.phar`, `findme` |
| Force password reset for all existing customers | hashes were public in the dump |
| Create `.env.example`; set prod `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true` | `.env` currently `APP_DEBUG=true` with live Hostinger SMTP creds |
| Delete dead files → log to `deleted.md` | `webpack.mix.js`, `resources/js/fabric.js`, `resources/views/partial/_Tools.blade.php` (255 dead lines), `partial/_Cart.blade.php`, `welcome.blade.php`, `home.blade.php`, `resources/views/auth/**`, `layouts/app.blade.php`, `adminAccountsController.php` (unrouted), models `customers`, `soldProducts`, `Genders`, `Sizes`, `Status`, `UserStatus`, `Variations`, `productStatus` |

> History rewrite is destructive and needs a force-push. Confirm before running it.

## Phase 1 — Laravel 10 → 12

- `composer.json`: `laravel/framework ^12`, `php ^8.3`, `laravel/sanctum ^4`. **Drop `guzzle/guzzle ^3.8`** (abandoned since 2015, sits alongside `guzzlehttp/guzzle ^7`). Drop `laravel/ui` — Phase 2 replaces the scaffold.
- Adopt the slim skeleton: `bootstrap/app.php` with `withMiddleware()` / `withExceptions()` replaces `app/Http/Kernel.php` and `app/Console/Kernel.php`.
- `phpunit.xml`: L12 format, **uncomment the sqlite `:memory:` lines** (tests currently run against the live MySQL DB).

## Phase 2 — Auth & authorization *(security-critical)*

**One identity source.** Delete the parallel session-key system (`isLoggedin`, `session('id')`, `session('username')`) — 17 Blade sites and 6 controller sites — and use `Auth::user()`/`Auth::id()`. Delete `app/Http/Middleware/cart.php`.

**Admin.** New `admin_users` table with a `role` column (owner/staff). `admin` guard properly asserted via `auth:admin`, not `session()->has('adminLoggedIn')` (`app/Http/Middleware/admin.php:18`). Gates/Policies in `AuthServiceProvider` (currently stock and empty). **Remove self-service admin registration**; replace with an artisan command `astee:make-admin`.

**Route restructure** — `routes/web.php` rewritten from a flat 254-line list into groups:

```php
Route::middleware(['auth', 'verified'])->group(...);          // customer
Route::prefix('admin')->middleware('auth:admin')->group(...); // ALL admin, writes included
```

Remove the duplicate `Auth::routes()` (`:50` and `:185`) and the `password.reset` name collision that makes customer reset emails link to the admin form.

**Verification & reset.** Delete `/emailVerified/{email}` and `/verifyAdmin/{email}`. Use Laravel's signed, expiring `verified` middleware. Replace `/searchedUser` (`LoginSignupController.php:111`, returns every `LIKE %input%` match with emails in editable inputs) with the standard non-enumerating response.

**Sessions.** `LoginSignupController.php:78-92` returns blocked/unverified users without `auth()->logout()` — they stay authenticated. Fix.

**Throttling.** Currently only `POST /login/process`. Add to: admin login, both password-reset senders, verification resend, contact form.

**Validation & ownership.** Create `app/Http/Requests/` (does not exist). FormRequests with `authorize()` for every mutating action. Policies fix the IDORs: `UserController.php:133` deletes a product from *every* user's cart; `submitCancel`, `orderRecieved`, `submitReview` never tie `$id` to the session user.

**Private files.** Valid IDs and payment proofs move to `storage/app/private`, hashed filenames (`->store()`, not `storeAs($clientOriginalName)`), served through a signed controller route behind the admin gate. Drop `svg` from the upload mime list. Remove the `/storage/` rewrite from the root `.htaccess`; DocumentRoot must be `public/`.

Add a security-headers middleware (CSP, HSTS, X-Frame-Options, X-Content-Type-Options) — none exist today. Delete the public mail-preview routes (`/invoice`, `/newOrder`, `/feedback`, `/passwordResetEmail`).

## Phase 3 — Schema rebuild & domain model

Replace the physical-table-move lifecycle (`product_on_hand` → `product_on_process` → `product_on_return_cancel`, each move a `create()` + `delete()` with no transaction) with a status column. This is the largest structural change and it deletes ~300 lines of copy-paste across `adminOnHandsController`, `adminOnProcessController`, `adminCancelReturnController` (894 lines, ~30% duplicated, already drifted: `total` is `price × quantity` in `moveProduct` but bare `price` in four of six `moveMultiple` arms, and one arm is wired to the wrong destination table).

One authoritative migration set:

| Table | Notes |
|---|---|
| `products` | catalog + inventory; `price decimal(12,2)`, `stock`, indexed |
| `carts` / `cart_items` | |
| `orders` | `status`, `subtotal`, `shipping_fee`, `total`, `paid_at` — all decimal |
| `order_items` | price/name **snapshotted** at purchase; `product_id` or `custom_design_id` |
| `payments` | provider, provider_ref (unique), amount, status, proof_path |
| `custom_designs` | canvas JSON, preview + print-file paths |
| `reviews`, `admin_users` | |

- Money: `decimal(12,2)` with `decimal:2` casts. Every money column is currently `int(11)` while `UserController.php:193` casts to `(float)` — decimals silently truncate.
- **Lookup tables → PHP backed enums** (`OrderStatus`, `ShirtSize`, `Variation`, `Gender`, `CancelReason`). Today each enum lives in three places: the FK'd table, the switch in `app/Traits/Types.php`, and a third copy in `dashboardController.php:87-93`. The tables are FK-enforced but **never read**. Delete `Types.php` and the lookup tables; enums become the single source of truth across all 54 Blade call sites.
- Define Eloquent relationships — there are currently **zero** in the entire app; every association is a manual `where()` or raw join.
- Add the missing indexes (`orders.created_at`, `order_items.status`, `payments.created_at`).
- Wrap every multi-write in `DB::transaction()` — `DB::transaction` appears **zero times** in `app/`.
- Seeder: demo catalog + one admin.

Also fixes here: `dashboardController.php` reads the `sales` table end-to-end **six times per request** to compute scalars (`:34,49,53,57,105`) and buckets months as `'M'` so Jan 2024 and Jan 2025 collide — replace with `GROUP BY` aggregates.

## Phase 4 — Checkout & payments

**Server-authoritative pricing.** The client sends `product_id` + `quantity` and nothing else. Delete every `price`/`total`/`subTotal` hidden input from `userCart.blade.php` and `checkout.blade.php`. New `app/Services/OrderService::place()`:

1. one transaction, `lockForUpdate()` on the product rows
2. prices read from `products.price`, subtotal/shipping/total computed server-side
3. stock check → whole order fails atomically if short

This also fixes `confirmCheckout` creating **one order row per line item** with a growing `productId` array (`$processingId` is never initialized, `orders::create` sits inside the `foreach`), the unreachable stock branch at `UserController.php:212-222` that falls through to an undefined `$productId`, and the cart wipe executing N times with no `userId` scope.

**PayMongo.** `PaymentGateway` contract + `PayMongoGateway` (GCash / Maya / cards / bank). Create a Checkout Session, redirect, and confirm via a **signature-verified, idempotent webhook** keyed on `payments.provider_ref` — the order is marked paid by the webhook, never by the browser redirect. COD stays as a second method. Delete `PaymentController.php` (dead PayMaya sandbox stub with `YOUR_PUBLIC_KEY` placeholders and a hardcoded ₱100).

Mail moves to `ShouldQueue` on the `database` driver — all 6 Mailables currently `use Queueable` but none implement `ShouldQueue`, so every send blocks the checkout request, uncaught (`UserController.php:250`).

## Phase 5 — DIY designer → orderable product

Rewrite `public/js/diy.js` (313 lines, global jQuery) as a Vite-bundled ES module importing the npm `fabric` package. Today fabric 5.3.1 loads from CDN on **every page of the site**, the npm copy is never bundled, and `fabric-history` is bundled but never called.

Functional fixes:
- style the **selected** object, not the last-added `customText`
- bold → `fontWeight` (currently both bold and italic write `fontStyle`, cancelling each other)
- a real **print area** with a bounding box; uploads constrained to it instead of scaling to fill the whole 400×400 canvas
- undo/redo on `object:added`/`removed`/`modified`, not `modified` alone
- don't wipe the canvas when the download confirm is cancelled (`diy.js:287` sits outside the `if`)
- responsive canvas (currently fixed 400×400)
- repoint the 17 broken swatches — the files exist in `public/images/` under different names than the `storage/images/` paths the view asks for
- stop loading `diy.js` on `contact_us.blade.php`, where it throws immediately

New flow: `POST /designs` persists canvas JSON + a high-res PNG (`toDataURL({multiplier})`) to the private disk → design attaches to a cart line → price from a server-side `DesignPricer` (base garment + per-side print + size) → normal checkout. Admin gets a custom-orders screen with print-file download. The Messenger handoff and the APK link come out of the UI.

## Phase 6 — UI redesign

**Structure first.** Real `layouts/app.blade.php` and `layouts/admin.blade.php` with slots. This kills the `@extends('components.header')` + `<x-header/>` double-`<head>` bug on 25 pages and the duplicate jQuery/fabric/`@vite` tags it emits.

**Design direction — apparel & screen printing.** Ink-on-fabric: high contrast, confident type, generous whitespace, product photography doing the work. Anchor on the existing orange `#f87b1f`, promoted from a stray hex into a proper token scale alongside a deep ink neutral. One display face for headings, one UI face — replacing the five families currently loaded from four sources of which only Poppins is applied. Remove the global `* { transition: 0.2s }` reset and the `li:hover` rule in `public/style.css`, and restore the focus outlines that file strips.

- Brand tokens in `tailwind.config.js` (`theme.extend` is empty today); add `public/js/**` to `content`.
- Blade component set: Button, Card, Badge, Input, Table, Modal, EmptyState.
- Storefront: homepage driven by real products (the grid is hardcoded `p1.jpg`–`p12.jpg`), PDP with size chart and live swatches, cart, checkout, order tracking.
- Admin: responsive — delete the `lg:hidden` "Not Availble for Mobile Devices" gate (`components/nav.blade.php:3`); collapse the three ~80%-identical product screens (onHand/proccessing/cancelReturn, 819 lines) into one; Chart.js from npm instead of the unpinned CDN.
- a11y: alt text (81 of 126 images are `alt=""`; three different photos share `alt="A's Tee Logo"`), semantic `<button>`s, `overflow-x` wrappers on tables.
- Assets: run `storage:link` (missing — most images 404 today), compress the 4.3 MB image set, lazy-load, inline SVG for icons currently shipped as 100–164 KB PNGs.
- Brand consistency: pick one of AsTee / A's Tee / A'sTee / a's Tee. Fix the footer copyright, which links to **flowbite.com** (`components/footer.blade.php:18`).

## Phase 7 — Tests & CI

sqlite `:memory:` + `RefreshDatabase`. Feature tests on the things that cost money or leak data:

- checkout total cannot be tampered via request input
- admin routes reject guests and non-admin users
- cart/order IDOR is blocked by policy
- payment webhook is idempotent and signature-verified
- stock decrements correctly and rolls back on failure

Plus Pint and a GitHub Actions workflow.

---

## Critical files

| Area | Files |
|---|---|
| Routing/auth | `routes/web.php`, `app/Http/Middleware/{admin,cart}.php`, `app/Http/Controllers/{LoginSignupController,adminIndexController}.php`, new `app/Http/Requests/**`, new `app/Policies/**` |
| Money | `app/Http/Controllers/UserController.php` (`:140-255`), `public/js/cart.js`, `resources/views/user/{userCart,checkout}.blade.php`, new `app/Services/OrderService.php` |
| Lifecycle | `app/Http/Controllers/admin{OnHands,OnProcess,CancelReturn}Controller.php`, `app/Traits/{Filter,FilterUser,Types}.php` |
| Payments | `app/Http/Controllers/Payment*Controller.php`, new `app/Services/Payments/**` |
| DIY | `public/js/diy.js`, `resources/views/user/DIY.blade.php` |
| UI | `resources/views/components/{header,nav,navbar,footer,scripts}.blade.php`, `tailwind.config.js`, `public/style.css` |

**Reused as-is:** the `@props` component pattern already works well — `components/accounts.blade.php` (138 lines) serves 3 admin screens, and `editForm`/`moveProduct`/`removeMultiple` are reused 8×/8×/3×. `app/Traits/FilterUser.php` genuinely earns its keep (the 3 account controllers are ~30 lines each); it gets tightened, not deleted. The `<dialog>`-based modals are a good baseline. Laravel's own password-reset broker flow is already correct and stays.

## Verification

Per phase:

- **0–1** — `composer install`, `php artisan about` reports Laravel 12; `git log --all -- u763116450_asTeeFinal.sql` returns empty.
- **2** — automated: guest `POST` to each admin write route returns 403/redirect (a test iterating the admin route group, so it can't silently regress). Manual: `/submitRegistration` is gone; `/verifyAdmin/{email}` 404s; a blocked user can't reach `/userProfile/myAccount`.
- **3** — `php artisan migrate:fresh --seed` on a scratch DB, then browse the storefront and admin. This currently fails; passing it is the phase gate.
- **4** — test posting a tampered `price`/`total` and assert the order total matches `products.price`. Live: PayMongo test-mode checkout end-to-end, then replay the webhook to prove idempotency.
- **5** — design → add to cart → checkout → admin downloads the print file. Verify the stored PNG is print-resolution, not 400×400.
- **6** — `npm run build`; view-source shows exactly one `<head>`; run the storefront and admin at 375/768/1280 via the browser tools.
- **7** — `vendor/bin/phpunit` green, `vendor/bin/pint --test` clean.

Full run: `php artisan migrate:fresh --seed && npm run build && php artisan serve`, then walk browse → DIY design → cart → checkout → pay (test mode) → admin fulfils → customer reviews.
