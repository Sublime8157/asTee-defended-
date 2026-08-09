## Fill this on every progress we made so far

Plan: [plan.md](plan.md) · Conventions: [checklist.md](checklist.md)

| Phase | Status | Branch |
|---|---|---|
| 0 — Repo hygiene & exposure | ✅ done | `chore/business-ready-phase-0` |
| 1 — Laravel 10 → 12 | ✅ done | `chore/business-ready-phase-0` |
| 2 — Auth & authorization | ⬜ | |
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
