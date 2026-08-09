## Fill this on every progress we made so far

Plan: [plan.md](plan.md) · Conventions: [checklist.md](checklist.md)

Per-phase notes (featured / deleted / progress / refactor) live in the phase folders:
[Phase 0](Phase%200/progress.md) ·
[Phase 1](Phase%201/progress.md) ·
[Phase 2a](Phase%202a/progress.md) ·
[Phase 2c](Phase%202c/progress.md) ·
[Phase 3](Phase%203/progress.md)

| Phase | Status | Branch |
|---|---|---|
| 0 — Repo hygiene & exposure | ✅ done | `chore/business-ready-phase-0` |
| 1 — Laravel 10 → 12 | ✅ done | `chore/business-ready-phase-0` |
| 2a — Route protection & auth hardening | ✅ done | `chore/business-ready-phase-0` |
| 2b — Identity unification, private files, policies | ✅ done (in Phase 3) | `feat/business-ready-phase-3` |
| 2c — Containerisation (Docker) | ✅ done | `chore/business-ready-phase-0` |
| 3 — Schema rebuild & domain model | ✅ done | `feat/business-ready-phase-3` |
| 4 — Checkout & PayMongo payments | ⬜ | |
| 5 — DIY designer as orderable product | ⬜ | |
| 6 — UI redesign | ⬜ | |
| 7 — Tests & CI | ⬜ | |

---

### Phase 0 — done

- Branched off `main`; pre-existing working-tree changes preserved in a baseline commit.
- Untracked the PII database dump; kept on disk as the Phase 3 schema reference.
- Removed 9.9 MB `public.zip` and 2.9 MB `composer.phar` from the repo.
- Deleted 11 verified-dead files (~470 lines). See [deleted.md](deleted.md).
- Created `.env.example` — the project previously could not be bootstrapped without the original `.env`.
- Verified and **rejected** 5 deletions the plan proposed: the password-reset views, `layouts/app.blade.php` and `HomeController` are all live.

### Phase 1 — done

- Laravel **10.50.2 → 12.65.0**, PHPUnit **10 → 11**, PHP requirement `^8.1 → ^8.2` (8.3.30 installed).
- Dropped `guzzle/guzzle ^3.8` (abandoned 2015, unused) and `spatie/laravel-ignition` (not in the L11+ skeleton; also removes its three `_ignition/*` routes).
- npm vulnerabilities **4 → 0** — fabric 5.3.0 → 7.4.0, `fabric-history` dropped, `tar` chain gone.
- `package.json` rebuilt: ~90 hand-listed transitive deps → 10 real ones.
- Adopted the slim skeleton — `bootstrap/app.php` + `bootstrap/providers.php` replace both Kernels, the exception Handler, 4 providers and 9 stock middleware.
- `phpunit.xml` now actually uses in-memory SQLite. It previously ran against the live MySQL database.

Verified: `about` reports 12.65.0 · `route:list` 139 routes · `view:cache` compiles every template · `npm run build` clean · `phpunit` green · HTTP smoke test of `/`, `/about-us`, `/DIY`, `/contact-us`, `/loginAdmin`, `/up` all 200.

> **Local MySQL is not running** (`SQLSTATE[HY000] [2002]`), so DB-backed routes like `/Product` 500 locally. Not an upgrade regression — needs the MySQL service started before Phase 3's `migrate:fresh`.

---

### Phase 2a — done

Route protection, which needed no schema change and closed the two Critical findings.

| Before | After |
|---|---|
| 48 of 51 mutating routes unauthenticated | 67 routes behind `admin`, 18 behind `auth` |
| Anyone could create a verified admin in 2 requests | Registration removed; `php artisan astee:make-admin` |
| `/emailVerified/{email}` verified any account | Signed, 48-hour expiring link |
| `admin` middleware checked a session boolean | Asserts `Auth::guard('admin')->check()` |
| Blocked users stayed authenticated | `logout()` on both reject paths |
| Throttling on 1 route | Throttling on 8 |
| No security headers | 5 headers, HSTS on TLS |
| `GET /logout` | `POST /logout` + CSRF |

Incidental fixes found on the way: `/storeProcessing` had a **trailing space in its URI**, so `adminScripts.js:88` had always been posting to a 404; and `/updateTable` routed to a method that does not exist, so it 500'd on every hit.

`tests/Feature/RouteProtectionTest.php` walks the live route table rather than a fixed list — a route added later without a guard fails the suite. It asserts the group sizes too, so it cannot pass vacuously if the grouping is ever lost.

Verified over HTTP with MySQL deliberately down, so a 302 proves the guard runs *before* the controller: admin GETs 302 → `/loginAdmin`, escalation routes 404, unsigned verification 403, headers present.

### Phase 2b — folded into Phase 3

These parts of Phase 2 touch controllers that the schema rebuild rewrites, so doing them now would mean editing the same code twice:

- Identity unification — replacing `session('id')` / `isLoggedin` with `Auth::id()` across 17 Blade and 6 controller sites.
- Private storage for valid-ID scans and payment proofs (still world-readable with guessable filenames — **Critical, still open**).
- Ownership policies for the cart/order IDORs.
- Admin roles.

### Phase 2c — done

Not in the original plan — added because Phase 1 left local MySQL unavailable and
Phase 3's `migrate:fresh` needs a reproducible database
(commit `619b132 feat: containerise the app with Docker`).

- 3-stage `Dockerfile`: Node asset build → Composer vendor → Apache + PHP 8.3 runtime.
- `docker-compose.yml`: `app` + `db` (MariaDB 10.11), healthchecked, named volumes.
- `docker/entrypoint.sh`: env bootstrap, DB wait, `storage:link`, cache clear.
- DocumentRoot moved to `public/`, which neutralises the root `.htaccess` exposure.
- `.dockerignore` keeps `.env` and `*.sql` out of image layers.

Small working-tree edits to the Docker files and `MakeAdmin.php` are still uncommitted.

---

### Phase 3 — done

The physical-table-move lifecycle is gone: `product_on_hand` → `product_on_process` →
`product_on_return_cancel` → `sales` collapse into `products` (catalog) plus
`order_items.status`. 894 lines of triplicated lifecycle controller become ~360 across two
controllers split by responsibility rather than by destination table.

| Before | After |
|---|---|
| Browser computed the order total, server wrote `$request->total` | `OrderService` reads `products.price` under `lockForUpdate` in one transaction |
| `DB::transaction` appeared 0 times in `app/` | Every multi-write is wrapped |
| 0 Eloquent relationships | Relationships on all 8 models; deleting a customer is one cascade |
| Money in `int(11)`, cast to `(float)` on write | `decimal(12,2)` with `decimal:2` casts |
| Lookup domains in 3 places each, drifted | 5 backed enums, single source across every call site |
| `/cart/{userId}`, `/myPurchase/{userId}` took any id | Owner comes from the guard |
| IDs and payment proofs world-readable by filename | Private disk, hashed names, streamed behind the admin gate |
| 16 models, 19 migrations | 8 models, 14 migrations |

Phase 2b folded in as planned — identity unification, private files and the cart/order IDORs all
lived in controllers this phase rewrote.

**Verified:** `migrate:fresh --seed` clean on scratch MariaDB; guest, admin and customer walked
through every screen; checkout posted with `total=1&price=1` produced an order priced from the
catalog with stock decremented correctly; `phpunit` 17 tests green.

Incidental: checkout mail is now wrapped in a try/catch — SMTP being unreachable used to turn an
already-committed order into a 500. Phase 4 moves it to the queue.

> Tests run against the containerised MariaDB locally: `pdo_sqlite` is commented out in
> `C:\php\php.ini`, so the in-memory SQLite connection `phpunit.xml` asks for cannot be opened on
> this machine. Uncommenting `extension=pdo_sqlite` fixes it; nothing in the repo needs to change.

---

**Outstanding from Phase 0 — needs the owner, not code:**

1. **Git history purge.** The PII dump is untracked but still present in every
   historical commit. `git filter-repo` is not installed; needs
   `pip install git-filter-repo`. The rewrite is destructive and requires a
   force-push to `github.com/Sublime8157/asTee-defended-`. Not run yet — waiting
   on confirmation.
2. **Credential rotation.** The bcrypt hashes in the dump were publicly readable
   for as long as the repo was public. Every account in it should be treated as
   compromised and forced through a password reset. Separately, the live
   Hostinger SMTP password sits in plaintext in `.env` — it was never committed,
   but it should be rotated as routine hygiene.
