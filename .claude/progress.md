## Fill this on every progress we made so far

Plan: [plan.md](plan.md) · Conventions: [checklist.md](checklist.md)

| Phase | Status | Branch |
|---|---|---|
| 0 — Repo hygiene & exposure | ✅ done | `chore/business-ready-phase-0` |
| 1 — Laravel 10 → 12 | ✅ done | `chore/business-ready-phase-0` |
| 2a — Route protection & auth hardening | ✅ done | `chore/business-ready-phase-0` |
| 2b — Identity unification, private files, policies | ⬜ folded into Phase 3 | |
| 3 — Schema rebuild & domain model | ⬜ | |
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
