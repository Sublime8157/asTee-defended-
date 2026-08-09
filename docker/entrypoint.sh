#!/usr/bin/env bash
set -euo pipefail

# -----------------------------------------------------------------------------
# .env
#
# .env is excluded from the image by .dockerignore — baking the developer's real
# SMTP and database credentials into a layer would ship them to anyone who pulls
# it. Configuration comes from compose environment variables instead; this file
# only exists because artisan expects one.
# -----------------------------------------------------------------------------
if [ ! -f .env ]; then
    echo "[entrypoint] no .env present, seeding from .env.example"
    cp .env.example .env
fi

if [ -z "${APP_KEY:-}" ] && ! grep -q '^APP_KEY=base64:' .env; then
    echo "[entrypoint] generating APP_KEY"
    php artisan key:generate --force --no-interaction
fi

# -----------------------------------------------------------------------------
# Wait for MySQL
#
# depends_on with a healthcheck covers most of this, but a container restarting
# faster than the database can still race it.
#
# Probed with PDO, not mysqladmin. php:8.3-apache is Debian trixie, whose
# default-mysql-client is MariaDB 11.8 — that client requires TLS by default and
# dies against the non-TLS 10.11 server with "SSL is required, but the server
# does not support it", so the loop could never succeed. pdo_mysql is the driver
# Laravel itself connects with, which makes this the honest readiness check.
# -----------------------------------------------------------------------------
if [ -n "${DB_HOST:-}" ]; then
    echo "[entrypoint] waiting for ${DB_HOST}:${DB_PORT:-3306}"
    for i in $(seq 1 60); do
        if php -r 'new PDO("mysql:host=".getenv("DB_HOST").";port=".(getenv("DB_PORT") ?: "3306").";dbname=".getenv("DB_DATABASE"), getenv("DB_USERNAME"), getenv("DB_PASSWORD"));' 2>/dev/null; then
            echo "[entrypoint] database is up"
            break
        fi
        if [ "$i" -eq 60 ]; then
            echo "[entrypoint] database did not become reachable in 60s" >&2
            exit 1
        fi
        sleep 1
    done
fi

# -----------------------------------------------------------------------------
# Storage
#
# public/storage is a symlink into storage/app/public. It is gitignored, so it
# never exists in a fresh checkout — which is why product images, avatars and
# the DIY shirt swatches 404 on a clean install.
# -----------------------------------------------------------------------------
php artisan storage:link --force --no-interaction || true

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

# -----------------------------------------------------------------------------
# Caches
#
# Cleared rather than warmed. config:cache would freeze the environment
# variables read at build time, which is wrong for a container whose config
# arrives at run time.
#
# Migrations are deliberately NOT run here. The migration set in this repo does
# not reproduce the production schema — orders.total, orders.paid and the whole
# payment_history table are missing from it — so `migrate` produces a database
# the application cannot run against. The compose file imports the SQL dump
# instead. Phase 3 replaces both with an authoritative migration set.
# -----------------------------------------------------------------------------
php artisan config:clear --no-interaction
php artisan route:clear --no-interaction
php artisan view:clear --no-interaction

echo "[entrypoint] ready — $(php artisan --version)"

exec "$@"
