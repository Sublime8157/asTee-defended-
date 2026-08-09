# Phase 3 — features

## Server-authoritative checkout

`app/Services/OrderService.php`. Customer-facing behaviour is unchanged — you pick items, you see
a total, you order — but the total is now computed from `products.price` inside a transaction with
the product rows locked, instead of being summed in the browser and posted back in an editable
text input.

*Why a service rather than leaving it in the controller:* the admin "sell to a customer" action on
the catalog screen needs exactly the same stock check, price read and snapshot. It calls
`placeFor()`; checkout calls `place()`, which reads the cart and then calls `placeFor()`.

## Order history that survives being reviewed

Reviewing a purchase used to delete the order line and insert a throwaway row into a `products`
table purely so `feedback.productId` had something to point at. A customer's purchase history
disappeared the moment they left feedback. Reviews now hang off `order_items`, one per line,
enforced by a unique key.

## Stock that comes back

Cancelling an order — by the customer from My Purchases, or by an admin from the order-line
screen — returns the quantity to `products.stock`. Nothing in the old code ever did this, in
either direction.

## Admin: sell to a named customer

The catalog screen's "Sell" action (formerly "MoveTo") creates a real order for a customer id with
a quantity, through the same `OrderService` as checkout. Previously it copied the product row into
`product_on_process` and deleted it from `product_on_hand`, which removed the product from the
catalog entirely no matter how many were bought.

## Admin: one order-line screen, two filters

Processing and Cancel/Return are the same table and the same partial, filtered by status. Changing
a line's status — including cancelling it, with a reason — is one form.

## Private document handling

Government IDs and bank transfer proofs are stored on a `private` disk under hashed names and
streamed by `AdminFileController` behind the admin guard. The route takes a record id, not a path,
so there is nothing for a caller to traverse.

*Why a controller rather than a signed URL:* a signed URL is still a URL that can be forwarded.
The admin gate is the requirement, and it is already there.

## Non-enumerating account lookup

"Forgot password" confirms nothing about whether an account exists. It looks up the exact username
or email, sends the reset link if there is a match, and returns the same page either way.
