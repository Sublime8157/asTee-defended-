# Phase 3 — files deleted

## Controllers — the triplicated lifecycle

| File | Lines | Why |
|---|---|---|
| `adminOnHandsController.php` | 294 | Catalog work moves to `AdminProductController`. |
| `adminOnProcessController.php` | 318 | Order lines move to `AdminOrderItemController`. |
| `adminCancelReturnController.php` | 282 | Same controller — cancel is a status, not a table. |
| `PaymentController.php` | 61 | Dead PayMaya sandbox stub with `YOUR_PUBLIC_KEY` placeholders and a hardcoded ₱100. Unrouted. Phase 4 brings a real gateway. |

894 lines of lifecycle controller become ~360 across two files that do not overlap.

## Models — sixteen become eight

`OnHand`, `Processing`, `CancelReturn`, `Sales`, `Products`, `cart`, `orders`, `adminLogin`,
`feedback`, `payment_history` and the six lookup models (`Genders`, `Sizes`, `Status`,
`UserStatus`, `Variations`, `productStatus`).

`Processing`, `CancelReturn` and `Sales` were the same order line in three tables.
The six lookup models were never read — the switches in `Types.php` were what views displayed.

## Traits

| File | Why |
|---|---|
| `app/Traits/Types.php` | The switch statements the enums replace. |
| `app/Traits/Filter.php` | Claimed to be generic, had one consumer, and hardcoded `where('paid','not_paid')` in `displayTrait`. Its `filterDateTrait` else branch referenced an unimported `payment_history`, so an empty date filter was a fatal error. Inlined into `PaymentHistoryController`. |

`FilterUser.php` is kept — three ~30-line account controllers justify it, as the plan said — but
its scope argument is a closure now rather than a `userStatus` integer. The pending screen used to
pass `'3'`, a status value that never existed in the data, so the pending list was always empty.

## Views

| File | Why |
|---|---|
| `admin/products/CancelReturnPartial.blade.php` | ~80% identical to `processingPartial`, differing only in the cancel-reason column. |
| `admin/products/sort/onhandProducts.blade.php` | A copy of `onHandPartial`. The sort endpoint returns the partial the page already uses. |
| `admin/products/sort/sortProducts.blade.php` | A copy of `processingPartial`, same reason. |
| `components/moveProduct.blade.php` | There is nowhere to move a row to. |

The bulk "Move" action goes with it — `removeMultiple.blade.php` offers Remove and Status.

The "add product" dialogs on the Processing and Cancel/Return screens are gone: an order line
comes from a customer checking out or from the catalog's Sell action. It cannot be typed into
existence, which is what `storeProcessing` and `storeCancelReturn` let an admin do.

Page sizes after: `onHand` 258 → 179, `proccessing` 292 → 108, `cancelReturn` 269 → 93.

## Migrations

The 19 migrations that described the old schema, including `create_users_table` — the stock
Laravel `users` table, which nothing ever used, because `App\Models\User` maps to `customers`.

## Fields removed from requests

Every hidden input that re-posted data the server already had: on checkout the description,
variation, gender, size, price, quantity and image path of every line, plus `total`, `subTotal`
and `shippingFee`; on cancel the whole line again; on review the line again plus `userId`. The
registration form's `userStatus`, which let whoever signed up choose their own blocked state.
