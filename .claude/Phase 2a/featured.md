# Phase 2a — features

**`php artisan astee:make-admin`** — new console command
(`app/Console/Commands/MakeAdmin.php`).

Creates a verified admin account from the shell, replacing the web registration
flow at `/regsiterAccount` + `/submitRegistration`. Prompts for email, username,
name and a hidden password; enforces a 12-character minimum with mixed case,
numbers and symbols, and uniqueness against `admin_login`.

*Why console-only:* the web flow was unauthenticated, and combined with the
unsigned `/verifyAdmin/{email}` route it let anyone create a verified admin in
two requests. Console creation means an attacker needs shell access on the
server, at which point the admin panel is no longer the weakest link.

```bash
php artisan astee:make-admin
```

```bash
php artisan astee:make-admin --email=owner@astee.store --username=owner
```

**Signed email verification** — verification links are now generated as
temporary signed URLs valid for 48 hours (`app/Mail/VerificationEmail.php`).
The link text tells the recipient about the expiry.

**Security headers** on every web response
(`app/Http/Middleware/SecurityHeaders.php`): `X-Content-Type-Options`,
`X-Frame-Options`, `Referrer-Policy`, `X-Permitted-Cross-Domain-Policies`,
`Permissions-Policy`, and `Strict-Transport-Security` when the request is
over TLS.
