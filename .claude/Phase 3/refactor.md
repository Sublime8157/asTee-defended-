# Phase 3 — refactoring

## Decisions, and why A over B

| Decision | Chosen | Why not the alternative |
|---|---|---|
| Enum backing | String (`to_pay`, `couple`, `xxxl`) | Int-backed would have been a smaller diff — the views already carried integer `<option>` values. But magic integers are the defect: `switch($moveTo) case 1/2/3` is how one bulk arm ended up wired to the wrong table, and `size 6`/`size 7` both silently meant XXL. A clean rebuild was already landing, so readable values cost nothing here that they would cost later. |
| Lifecycle | `order_items.status` | The plan's call, and the code agreed with it: three controllers had drifted apart maintaining the same five methods, and the moves were `create()` + `delete()` with no transaction. |
| Catalog vs order lines | Two controllers | Splitting the three old controllers by *responsibility* rather than by destination table is what removes the duplication. Split any other way and the same five methods reappear. |
| `carts` table | Skipped | The plan listed `carts` + `cart_items`. A cart is its items until guest checkout exists; a parent row with nothing on it but a `user_id` earns nothing. `cart_items` carries `unique(user_id, product_id)`, which is the constraint that actually mattered. |
| `custom_designs` table | Skipped | Nothing references it until Phase 5, which can add it together with `order_items.custom_design_id` in one migration rather than leaving an orphan FK in the meantime. |
| `sales` table | Dropped, not ported | A sale is an order with money against it: `whereNotNull('paid_at')`. A second table kept in step by hand is how `removePaymentsRecords` ended up with a `whereIn` against a model instance. |
| Payment amount | `orders.total` | Was an operator-typed field validated only as `integer`, so a mistyped figure became the recorded sale. It is the order total or it is not a payment for that order. |
| Shipping fee | `OrderService::SHIPPING_FEE` | The ₱60 was real — it lived in `value="60"` on an editable input and was added to the total by a script in the page — so removing it would have quietly cut ₱60 from every order. A constant until shipping varies by destination; marked `ponytail:`. |
| Money arithmetic | `decimal(12,2)` + `decimal:2` casts, `round()` at the boundaries | Integer centavos would be more rigorous, but every column, every view and every Blade format string would need to know about the scaling. At this order size the rounding is exact and the plan asked for decimal. |
| Mail on checkout | Wrapped in try/catch | Found during verification, not planned. The order commits before the mail sends; an unreachable SMTP server turned a placed order into a 500. The real fix is the queue, which is Phase 4 — this is the two-line stopgap so the phase does not ship a worse failure mode than it inherited. |
| `productsController`, `UserController` names | Left alone | Renaming for casing consistency is diff noise in a phase that already rewrites their contents. `AdminProductController` / `AdminOrderItemController` are new names because they are new responsibilities. Phase 6 can tidy the rest. |
| `FilterUser` | Kept, tightened | The plan is right that three ~30-line controllers justify it. Its `$userStatus` integer became a closure, which is what let the pending screen stop passing `'3'` — a value no row ever had. |
| Dashboard `DATE_FORMAT` | MySQL-specific, marked `ponytail:` | Portable month grouping in Eloquent means grouping in PHP, which is the full-table read this phase removed. The app deploys on MariaDB and docker-compose pins it. |

## Duplication removed

| Was | Now |
|---|---|
| 3 lifecycle controllers, 894 lines, ~30% duplicated | 2 controllers, ~360 lines, no overlap |
| 16 models | 8 |
| 5 hand-typed copies of the variation/gender/size option lists | `Enum::options()` |
| 4 copies of the cancel-reason list, all drifted | `CancelReason::options()` |
| 3 copies of the description truncation | `Product::$shortDescription` |
| 8 copies of `'storage/images/' . $x->image_path` | `$model->image_url` |
| 3 near-identical row partials + 2 sort copies | 2 partials, included by the pages and returned by the sort endpoints |
| 6 controllers + 2 traits interpolating `sortBy` into `orderBy()` | `app/Traits/SortsQueries.php`, whitelisted |

## Left for later, deliberately

- `@extends('components.header')` + `<x-header/>` still emits two `<head>` blocks on 25 pages.
  Phase 6 owns the layout rewrite; touching it here would have collided with every view edit.
- Controller and model naming is still mixed case. Phase 6.
- `public/js/cart.js` still computes a display total in the browser. It is display only now —
  the server ignores everything it sends about money — and Phase 6 rewrites the asset layer.
- Mail is still synchronous. Phase 4.
