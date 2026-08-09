## Fill this with every feature we update or support

### Phase 2a

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

### Containerisation

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

*Decisions worth recording:*

- **MariaDB 10.11, not MySQL.** The dump header reads
  `10.11.7-MariaDB-cll-lve`, the schema uses MariaDB
  `CHECK (json_valid(...))`, and the patch file uses
  `ADD COLUMN IF NOT EXISTS` — MariaDB-only syntax that MySQL 8 rejects.
- **Apache + mod_php over nginx + php-fpm.** One container, one process, and
  the repo is already Apache-shaped (two `.htaccess` files).
- **DocumentRoot is `public/`**, which makes the root `.htaccess` — the one
  that serves the entire project directory including `.env` and the SQL dump —
  inert. This is the fix the security review asked for.
- **No automatic migrations.** They fail against this schema, so the entrypoint
  would crash-loop. The dump is imported instead until Phase 3.
- **`MAIL_MAILER: log`.** The repo `.env` holds live Hostinger SMTP
  credentials; a local stack must not be able to mail real customers.

**Security headers** on every web response
(`app/Http/Middleware/SecurityHeaders.php`): `X-Content-Type-Options`,
`X-Frame-Options`, `Referrer-Policy`, `X-Permitted-Cross-Domain-Policies`,
`Permissions-Policy`, and `Strict-Transport-Security` when the request is
over TLS.
