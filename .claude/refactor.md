## Fill this with every refactor we made

Per-phase copies live in the phase folders:
[Phase 0](Phase%200/refactor.md) ·
[Phase 1](Phase%201/refactor.md) ·
[Phase 2a](Phase%202a/refactor.md) ·
[Phase 2c](Phase%202c/refactor.md) ·
[Phase 3](Phase%203/refactor.md)

### Phase 0 — repo hygiene & exposure

**`.gitignore` — added `*.sql`, `composer.phar`, `*.zip`**

The repo tracked a production database dump with live customer PII and bcrypt
hashes. Ignoring the file is not enough on its own — it is still reachable in
git history — but it stops the bleeding while the history rewrite is scheduled.
`!database/**/*.sql` keeps the door open for legitimate schema fixtures.

*Why a blanket `*.sql` over naming the one file:* the failure mode being
prevented is "someone drops another dump in the project root". Naming a single
file only prevents the mistake that already happened.

**`.env.example` — created**

The project had none, so it could not be bootstrapped by anyone without the
original `.env`. Added with placeholders plus the keys later phases need:
`SESSION_SECURE_COOKIE`, `PAYMONGO_*`, `SHIPPING_FEE`, and the three
`MAIL_*_ADDRESS` values that are currently hardcoded in controllers
(`adminIndexController:50`, `UserController:252`, `ContactUsController:23`).

`QUEUE_CONNECTION` defaults to `database` rather than `sync`, ahead of Phase 4
moving mail off the request thread.

**Deferred from the plan: lookup-model deletion**

The plan had Phase 0 deleting `Genders`, `Sizes`, `Status`, `UserStatus`,
`Variations` and `productStatus`. Verification showed each is referenced by
`database/seeders/multipleSeeder.php` and friends. Deleting the models while
the seeders still call `Model::insert()` breaks `php artisan db:seed`, which
violates the rule that every phase leaves the app runnable.

*Decision — defer over delete-and-patch:* patching the seeders now means
writing seeder code that Phase 3 immediately throws away when the lookup tables
become PHP backed enums. Deferring costs nothing and keeps the change coherent:
models, seeders and tables all go in one commit.

---

### Phase 1 — Laravel 10.50 → 12.65

**Framework upgrade**

Straightforward: PHP 8.3.30 was already installed, and no application code
depended on anything removed between 10 and 12. The only stumble was a stale
`bootstrap/cache/packages.php` still listing the removed Ignition provider —
cleared with `rm bootstrap/cache/*.php`.

*Why upgrade rather than harden in place:* Laravel 10 no longer receives
security fixes. Phase 2 rewrites the middleware and routing layer regardless,
so deferring the upgrade would mean writing that layer twice — once against
`Http/Kernel.php` and again against `bootstrap/app.php`.

**fabric 5.3.0 → 7.4.0, fabric-history dropped**

`npm audit` flagged two high-severity fabric advisories (stored XSS via SVG
export, improper escaping in `Gradient` colorStops) plus a critical `tar`
chain via `@mapbox/node-pre-gyp`.

*Why bump the major now rather than at Phase 5:* the npm `fabric` package is
not bundled by anything today — `DIY.blade.php` loads fabric 5.3.1 from a CDN,
and the only npm import lived in the now-deleted `resources/js/fabric.js`. So
the bump carries no runtime risk, and Phase 5 has to rewrite `diy.js` as an ES
module either way. Writing that rewrite against fabric 5's legacy `fabric.*`
global namespace would mean rewriting it a second time.

`fabric-history` was dropped rather than upgraded: it pins `fabric <7`, it was
bundled into `app.js`, and `diy.js` never calls it — the designer hand-rolls
its own undo/redo stacks. Removing it resolved the version pin and deleted an
unused dependency in one move. Phase 5 implements undo/redo against fabric's
own API.

Result: 4 vulnerabilities (1 critical, 3 high) → 0.

**package.json rebuilt**

`dependencies` listed ~90 packages — `anymatch`, `balanced-match`, `is-glob`,
`queue-microtask` and the rest of Tailwind's transitive tree, hand-copied in.
Reduced to the 4 packages actually imported plus 6 build tools. `node_modules`
drops to 205 packages.

**The slim skeleton**

Adopted rather than kept, even though Laravel 12 runs the legacy structure
fine. *Why:* Phase 2 rewrites middleware registration and route grouping. Doing
that against `bootstrap/app.php` costs the same as against `Http/Kernel.php`,
and leaves a structure that matches current Laravel documentation — which is
what a future maintainer will expect.

Every deletion was checked against the framework's own copy first. Nine
published middleware turned out to be pure stock. The single behavioural
difference in the whole set was `RedirectIfAuthenticated`'s use of
`RouteServiceProvider::HOME`, preserved as `redirectUsersTo('/home')`.

*Note on `TrimStrings`:* it looked customized — it declares `$except` for the
three password fields — but the framework's own `TrimStrings` already carries
exactly those three. The subclass added nothing. This is the kind of thing that
looks load-bearing and isn't; worth verifying rather than assuming in either
direction.

**Deferred to Phase 2**

`laravel/ui` is kept for now. `routes/web.php` calls `Auth::routes()` twice and
the `app/Http/Controllers/Auth/*` controllers extend its traits, so removing it
here would break the app mid-phase. It goes when auth is rewritten.

---

### Phase 2a — route protection

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

---

### Phase 2c — containerisation

- **MariaDB 10.11, not MySQL.** The dump header reads `10.11.7-MariaDB-cll-lve`,
  the schema uses MariaDB `CHECK (json_valid(...))`, and the patch file uses
  `ADD COLUMN IF NOT EXISTS` — MariaDB-only syntax that MySQL 8 rejects.
- **Apache + mod_php over nginx + php-fpm.** One container, one process, and the
  repo is already Apache-shaped (two `.htaccess` files).
- **DocumentRoot is `public/`**, which makes the root `.htaccess` — the one that
  serves the entire project directory including `.env` and the SQL dump — inert.
  This is the fix the security review asked for.
- **No automatic migrations.** They fail against this schema, so the entrypoint
  would crash-loop. The dump is imported instead until Phase 3.
- **`MAIL_MAILER: log`.** The repo `.env` holds live Hostinger SMTP credentials;
  a local stack must not be able to mail real customers.

### Phase 3 — schema rebuild

Decisions recorded in [Phase 3/refactor.md](Phase%203/refactor.md), including why enums are
string-backed rather than int-backed, why `carts` and `custom_designs` were skipped from the plan's
table list, why `sales` was dropped rather than ported, and why the ₱60 shipping fee became a
constant rather than disappearing.
