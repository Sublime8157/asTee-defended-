# Phase 1 — Laravel 10 → 12

Status: ✅ done · Branch `chore/business-ready-phase-0`

- Laravel **10.50.2 → 12.65.0**, PHPUnit **10 → 11**, PHP requirement `^8.1 → ^8.2` (8.3.30 installed).
- Dropped `guzzle/guzzle ^3.8` (abandoned 2015, unused) and `spatie/laravel-ignition`
  (not in the L11+ skeleton; also removes its three `_ignition/*` routes).
- npm vulnerabilities **4 → 0** — fabric 5.3.0 → 7.4.0, `fabric-history` dropped, `tar` chain gone.
- `package.json` rebuilt: ~90 hand-listed transitive deps → 10 real ones.
- Adopted the slim skeleton — `bootstrap/app.php` + `bootstrap/providers.php` replace both
  Kernels, the exception Handler, 4 providers and 9 stock middleware.
- `phpunit.xml` now actually uses in-memory SQLite. It previously ran against the live MySQL database.

**Verified:** `about` reports 12.65.0 · `route:list` 139 routes · `view:cache` compiles every
template · `npm run build` clean · `phpunit` green · HTTP smoke test of `/`, `/about-us`, `/DIY`,
`/contact-us`, `/loginAdmin`, `/up` all 200.

> **Local MySQL is not running** (`SQLSTATE[HY000] [2002]`), so DB-backed routes like `/Product`
> 500 locally. Not an upgrade regression — needs the MySQL service started before Phase 3's
> `migrate:fresh`. (Since resolved for local work by the Docker stack — see Phase 2c.)
