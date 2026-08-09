# Phase 2a — refactors

**Splitting Phase 2**

The plan had Phase 2 doing route protection *and* identity unification *and*
private file storage *and* policies. Tracing the code showed the last three all
edit controllers that Phase 3's schema rebuild rewrites — doing them now means
editing the same methods twice.

Route protection has no such coupling: it lives almost entirely in
`routes/web.php`. So Phase 2 was split, and 2a shipped the two Critical
findings on its own. *Cost of the split:* the valid-ID/payment-proof exposure
stays open one phase longer. Accepted because it needs the same controller
rewrite as the rest of 2b, and shipping route protection first closes the
larger hole sooner.

**Preserving URIs and route names**

Every URI and route name is unchanged. Blade `route()` helpers and the 11
hand-written jQuery files in `public/js/` hardcode both — `products.js` posts
to a literal `/filterProducts`, `orderHistory.js` to `/searchOrder`, and so on.
Renaming would have turned a contained security fix into a site-wide breakage
with no security benefit.

**Removing `Auth::routes()` rather than deduplicating it**

It was called twice (`:50` and `:185`), and both calls registered
`password.reset` / `password.update` — names the admin reset controller then
re-registered, so `route('password.reset')` resolved to the *admin* form and
customer reset emails linked to the wrong page. It also made `route:cache` fail
on duplicate names.

Grepping every name it registers (`login`, `register`, `logout`,
`password.request`, `password.email`, `password.confirm`, `verification.*`)
found usages only in the dead Bootstrap scaffold — and in `layouts/app.blade.php`
the whole nav that referenced them sits inside a `{{-- --}}` comment. So the
call could be deleted outright rather than deduplicated.

That left no route named `login`, which Laravel's `Authenticate` middleware
redirects to. Handled with `redirectGuestsTo('/')` in `bootstrap/app.php`,
pointing at the storefront login that actually exists.

**Signed URL over Laravel's built-in email verification**

Laravel's `MustVerifyEmail` + `verified` middleware is the conventional answer,
but it would mean changing the `User` model contract, the notification, the
route names and the `customers.email_verified_at` handling — a wide change to
close one hole.

A `temporarySignedRoute` closes exactly the same hole: only someone holding the
emailed link can verify, and the link expires. Two lines in the Mailable, one
`signed` middleware on the route, existing URL structure preserved. The
built-in flow is the better long-term home and is worth revisiting once Phase 3
settles the user model.

**`admin` middleware: guard check, not session flag**

Worth noting *why* this was safe to tighten. `adminIndexController::adminLogin`
already calls `auth()->guard('admin')->attempt()` before setting the
`adminLoggedIn` flag, so the guard session was always being established — the
flag was redundant belt-and-braces that happened to be the only thing checked.
Switching to `Auth::guard('admin')->check()` is strictly stronger with zero
behaviour change for legitimate admins.

**No CSP yet**

Deliberate. The storefront loads jQuery, fabric.js and Chart.js from three
CDNs and relies on inline `onclick` handlers and inline `<script>` blocks. Any
CSP that permitted all that would need `unsafe-inline` and `unsafe-eval`, which
is theatre. Phase 6 moves those to bundled assets; the policy goes in then.

**Incidental bugs found**

Two latent breakages surfaced while regrouping, both invisible until you read
the routes closely:

- `Route::post('/storeProcessing ', ...)` — trailing space in the URI. The AJAX
  call at `public/js/adminScripts.js:88` posts to `/storeProcessing`, so admin
  "add processing product" had always been silently hitting a 404.
- `Route::get('/updateTable', [adminOnProcessController::class, 'updateTable'])`
  — that method does not exist on the controller. Every hit was a 500.
