# Phase 2a — Route protection & auth hardening

Status: ✅ done · Branch `chore/business-ready-phase-0`

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

Incidental fixes found on the way: `/storeProcessing` had a **trailing space in its URI**, so
`adminScripts.js:88` had always been posting to a 404; and `/updateTable` routed to a method that
does not exist, so it 500'd on every hit.

`tests/Feature/RouteProtectionTest.php` walks the live route table rather than a fixed list — a
route added later without a guard fails the suite. It asserts the group sizes too, so it cannot
pass vacuously if the grouping is ever lost.

**Verified** over HTTP with MySQL deliberately down, so a 302 proves the guard runs *before* the
controller: admin GETs 302 → `/loginAdmin`, escalation routes 404, unsigned verification 403,
headers present.

## Phase 2b — folded into Phase 3

These parts of Phase 2 touch controllers that the schema rebuild rewrites, so doing them now would
mean editing the same code twice:

- Identity unification — replacing `session('id')` / `isLoggedin` with `Auth::id()` across
  17 Blade and 6 controller sites.
- Private storage for valid-ID scans and payment proofs (still world-readable with guessable
  filenames — **Critical, still open**).
- Ownership policies for the cart/order IDORs.
- Admin roles.
