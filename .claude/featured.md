## Fill this with every feature we update or support

Per-phase copies live in the phase folders:
[Phase 0](Phase%200/featured.md) ·
[Phase 1](Phase%201/featured.md) ·
[Phase 2a](Phase%202a/featured.md) ·
[Phase 2c](Phase%202c/featured.md)

### Phase 0 — repo hygiene

No user-facing features. Developer-facing: **`.env.example`** created, so the
project can be bootstrapped without the original `.env`.

### Phase 1 — Laravel 10 → 12

No user-facing features. Developer-facing: `phpunit.xml` now really uses
in-memory SQLite (it previously ran against the live database), and the build
surface dropped from ~90 declared npm packages to 10.

### Phase 2a — route protection

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

### Phase 2c — containerisation

**`docker compose up --build`** brings up the whole app — Apache + PHP 8.3 with
prebuilt Vite assets, and MariaDB 10.11.

```bash
cp u763116450_asTeeFinal.sql docker/mysql-init/01-schema.sql
docker compose up --build          # http://localhost:8000
```

Full notes in [docker/README.md](../docker/README.md).

| File | Purpose |
|---|---|
| `Dockerfile` | 3 stages — Node asset build, Composer vendor, Apache runtime |
| `docker-compose.yml` | `app` + `db`, healthchecked, named volumes |
| `docker/entrypoint.sh` | env bootstrap, DB wait, `storage:link`, cache clear |
| `docker/apache/000-default.conf` | vhost with DocumentRoot at `public/` |
| `docker/php/php.ini` | upload limits, opcache, `display_errors=Off` |
| `docker/mysql-init/02-patch.sql` | the columns the production dump predates |
| `.dockerignore` | keeps `.env` and `*.sql` out of image layers |

Decisions behind the stack are in [Phase 2c/refactor.md](Phase%202c/refactor.md).
