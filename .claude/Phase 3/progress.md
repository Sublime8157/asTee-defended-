# Phase 3 — Schema rebuild & domain model

Status: ✅ done · Branch `feat/business-ready-phase-3`

The largest structural change in the plan, and the one the phase gate is written against:
`php artisan migrate:fresh --seed` on a scratch database, then browse the storefront and admin.
That command previously produced a database the application could not run against.

Phase 2b was folded in here, as [Phase 2a](../Phase%202a/progress.md) predicted — identity
unification, private file storage and the cart/order IDORs all live in controllers this phase
rewrote anyway.

## Commits

| Commit | What |
|---|---|
| `1384541` | Backed enums for the five lookup domains |
| `67de52f` | One authoritative migration set |
| `80bcba5` | Models with real Eloquent relationships |
| `80d1332` | Controller layer onto the new schema |
| `8b3a9c3` | Views onto the new schema, selects driven by the enums |

## The lifecycle is a column, not three tables

```
before:  product_on_hand ──► product_on_process ──► sales
                                    │
                                    ▼
                          product_on_return_cancel

after:   products (catalog)   order_items.status
```

Every transition used to be a `create()` into one table plus a `delete()` from another, with no
transaction between them — an interrupted move duplicated or destroyed the line. Three controllers
re-implemented the same five methods across 894 lines, and had already drifted apart:

- `total` was `price × quantity` in `moveProduct` but bare `price` in four of six `moveMultiple` arms.
- `adminOnProcessController`'s bulk "move to cancel" arm wrote to `OnHand`.
- Moving a product out of `product_on_hand` removed the whole product from the catalog however
  many of it were bought, so the stock count was lost for every other customer.

They are now two controllers split by responsibility: `AdminProductController` owns the catalog,
`AdminOrderItemController` owns order lines. The Processing and Cancel/Return screens are one
query with a different status filter.

## Money is server-authoritative

`app/Services/OrderService.php`. The request carries product ids, an address, a contact number and
a payment method. It does not carry money. Prices are read from `products` inside one
`DB::transaction` with `lockForUpdate` on the rows being sold.

Before: `public/js/cart.js:98` summed the total, it travelled in a GET query string,
`checkout.blade.php:88,91,97` rendered it into editable text inputs, and `UserController.php:231`
wrote `$request->total` to the database — a field absent from the validation rules entirely.

That one function also fixed a cluster of bugs that had nothing to do with tampering: one order
row created per line item inside the loop while appending to a never-initialised `$processingId`
array, a stock branch whose `else` arm referenced an undefined `$productId`, and a cart wipe that
ran N times with no `userId` scope — checking out emptied that product from *every* customer's cart.

`DB::transaction` appeared zero times in `app/` before this phase.

## What else the schema made possible

| Fix | Was |
|---|---|
| Cancelling an order returns the stock | Nothing ever put it back |
| Deleting a customer is one cascade | Six manual deletes that missed `payment_history` |
| Dashboard is three aggregate queries | Six full-table reads to compute scalars |
| Chart months are `Y-m` | `format('M')`, so Jan 2024 and Jan 2025 shared a bar |
| Filtered sales sum `orders.total` | Summed `amount × quantity` where amount was already the total |
| Review keeps the purchase | `submitReview` deleted the order line, so history vanished on review |
| Featured reviews toggle | Insert wrote `1`, toggle wrote `2`, homepage queried `2` — one-way |
| Sort columns are whitelisted | `orderBy($request->input('sortBy'))` in six controllers and two traits |

## Phase 2b, folded in

- **Identity.** The parallel session keys (`isLoggedin`, `id`, `username`, `profile`,
  `verification`) are gone from all 6 controller and 17 Blade sites. Views read the guard.
- **Ownership.** `/cart/{userId}` and `/userProfile/myPurchase/{userId}` took whatever id was in
  the URL; `submitCancel`, `orderRecieved` and `submitReview` took an id from the body and never
  tied it to anyone. Customer routes derive the owner from the guard, and every order-line action
  goes through `ownedItems()`.
- **Private files.** Government IDs and bank transfer proofs move to a `private` disk with hashed
  names, streamed by `AdminFileController` behind the admin guard. They were world-readable under
  the uploader's own filename, so one upload could overwrite another by choosing the same name.
  `svg` is dropped from every image mime list.
- **Account enumeration.** `/searchedUser` returned every `LIKE %input%` match with photos and
  emails in editable inputs. It now sends the reset link server-side and says the same thing
  whether or not the account exists.

## Incidental fixes found on the way

- `customers.contact` was `bigint`, so `09171234567` lost its leading zero on every insert.
- The storefront gender filter emitted `value=" 1"` with a leading space and never matched.
- `ShirtSize` 6 and 7 both returned "XXL", so size 7 was unreachable in the UI. It is XXXL.
- `payment_history` search queried a `customers_id` column that does not exist — any search 500'd.
- `Filter::filterDateTrait`'s else branch referenced an unimported class, so an empty date filter
  was a fatal error rather than an unfiltered list.
- Both date filters ran `whereBetween` when *either* bound was filled, so a start date with no end
  date matched nothing.
- `QUEUE_CONNECTION=database` had no `jobs` table behind it.
- `.env.example` declared `MAIL_ORDERS_ADDRESS` and two siblings in Phase 0; nothing read them.
  They are wired to `config('mail.inboxes.*')` now.
- Checkout mail is wrapped in a try/catch. Found during verification: SMTP was unreachable, and
  because the two `Mail::send` calls run inline and uncaught *after* the order commits, a placed
  order returned a 500 and invited the customer to order again. Phase 4 moves this to the queue.

## Verification

`php artisan migrate:fresh --seed` against a scratch MariaDB 10.11 — clean, 14 migrations, seeded
19 customers, 1 admin, 24 products, 8 orders, 18 order lines covering all six statuses.

Browsed as guest, as the seeded admin and as the seeded customer:

- Guest: `/`, `/Product`, `/about-us`, `/DIY`, `/contact-us`, `/loginAdmin`, `/findUser` → 200.
  Every customer route → 302 `/`; every admin route → 302 `/loginAdmin`.
- Admin: dashboard, onHand, proccessing, cancelReturn, orders, payments, sales, all three account
  screens, feedbacks, managePassword → 200.
- Customer: home, cart, myAccount, myPassword, myPurchase and every status tab → 200.

Checkout end to end with `total=1&price=1` in the body: redirected to `myPurchase`, order written
with subtotal 1996.00 + shipping 60.00 = 2056.00 read from `products.price`, stock decremented by
exactly the ordered quantity, cart cleared.

`vendor/bin/phpunit` — 17 tests, 66 assertions, green.

> Run locally against the containerised MariaDB: `pdo_sqlite` is commented out in `C:\php\php.ini`,
> so the in-memory SQLite connection `phpunit.xml` asks for cannot be opened on this machine.
> Uncommenting `extension=pdo_sqlite` fixes it; nothing in the repo needs to change.
