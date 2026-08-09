## Fill this with every refactor we made

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
