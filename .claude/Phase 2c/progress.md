# Phase 2c — Containerisation

Status: ✅ done (commit `619b132 feat: containerise the app with Docker`) ·
Branch `chore/business-ready-phase-0`

Not in the original plan — added because Phase 1 left local MySQL unavailable and
Phase 3's `migrate:fresh` needs a reproducible database.

- 3-stage `Dockerfile`: Node asset build → Composer vendor → Apache + PHP 8.3 runtime.
- `docker-compose.yml`: `app` + `db` (MariaDB 10.11), healthchecked, named volumes.
- `docker/entrypoint.sh`: env bootstrap, DB wait, `storage:link`, cache clear.
- DocumentRoot moved to `public/`, which neutralises the root `.htaccess` exposure.
- `.dockerignore` keeps `.env` and `*.sql` out of image layers.

Details in [featured.md](featured.md) and [refactor.md](refactor.md).

**Open:** small working-tree edits to `Dockerfile`, `docker-compose.yml`,
`docker/entrypoint.sh`, `docker/README.md` and `app/Console/Commands/MakeAdmin.php`
are uncommitted as of this writing.
