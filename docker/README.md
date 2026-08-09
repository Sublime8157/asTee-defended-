# Running asTee in Docker

Two containers: `app` (Apache + PHP 8.3, Laravel 12, prebuilt Vite assets) and
`db` (MariaDB 10.11, matching production).

## First run

```bash
cp u763116450_asTeeFinal.sql docker/mysql-init/01-schema.sql
docker compose up --build
```

Then open <http://localhost:8000>.

### Why the manual copy

The app cannot create its own schema. `database/migrations/` does not reproduce
the production database — `orders.total`, `orders.paid` and the whole
`payment_history` table are missing from it, and
`2024_04_10_232734_create_feedback_table.php` called a nonexistent
`->nulalble()` method, so `php artisan migrate` aborted outright. The dump is
the only source of a schema the application can actually run against.

The dump is gitignored (it holds real customer names, addresses, phone numbers
and bcrypt hashes), so it cannot ship in the repo or the image. Copying it in
is a deliberate, local-only step.

`docker/mysql-init/02-patch.sql` then adds the three things the dump predates.

> Phase 3 of the business-ready work replaces both files with one authoritative
> migration set, at which point this becomes `docker compose exec app php
> artisan migrate:fresh --seed`.

### Running without the dump

Skip the copy and the stack still boots — you get an empty database. Static
pages (`/`, `/about-us`, `/DIY`, `/contact-us`, `/loginAdmin`) work; anything
DB-backed returns a 500.

## Everyday commands

```bash
docker compose up -d                       # start
docker compose logs -f app                 # tail application logs
docker compose exec app bash               # shell in the container
docker compose exec app php artisan tinker
docker compose down                        # stop, keep data
docker compose down -v                     # stop and DESTROY the database
```

Create an admin account — self-service admin registration was removed because
it was unauthenticated:

```bash
docker compose exec app php artisan astee:make-admin
```

## Configuration

Compose reads these from a `.env` in the project root, all with defaults:

| Variable | Default | Notes |
|---|---|---|
| `APP_PORT` | `8000` | Host port for the storefront |
| `APP_KEY` | *(empty)* | Generated on first boot. Set it to keep sessions valid across rebuilds. |
| `DB_DATABASE` | `asTeeFinal` | |
| `DB_USERNAME` | `astee` | |
| `DB_PASSWORD` | `secret` | |
| `DB_ROOT_PASSWORD` | `root` | |
| `DB_PORT` | `3306` | Bound to `127.0.0.1` only |

`MAIL_MAILER` is forced to `log` — the repo's `.env` carries live Hostinger SMTP
credentials, and a local stack must not be able to mail real customers. Sent
mail appears in `storage/logs/laravel.log`.

`QUEUE_CONNECTION` is `sync` because this schema has no jobs table yet. Phase 4
adds it and moves mail off the request thread.

## Notes on the image

**DocumentRoot is `public/`.** The repo's root `.htaccess` rewrites requests
into `public/` and maps `/storage/` onto `storage/app/public/`, which means the
whole project directory is served — `.env`, `vendor/`, `storage/` and the SQL
dump included, protected only by rewrite ordering. Pointing DocumentRoot at
`public/` is the correct fix and makes that file inert. The vhost additionally
refuses to serve dotfiles and `.sql`/`.env`/`.log` files.

**`storage:link` runs at startup.** The symlink is gitignored, so it never
exists in a fresh checkout — which is why product images, avatars and 17 of the
18 DIY shirt swatches 404 on a clean install.

**Migrations do not run automatically.** They would fail against this schema.

**Uploads persist** in the `astee-storage` volume across rebuilds.

**Build stages** are separated so editing a Blade file does not re-run
`composer install` or `npm ci`. `--no-dev` keeps PHPUnit, Pint and Sail out of
the runtime image.
