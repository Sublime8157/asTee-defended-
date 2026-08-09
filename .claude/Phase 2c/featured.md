# Phase 2c — features (containerisation)

**`docker compose up --build`** brings up the whole app — Apache + PHP 8.3 with
prebuilt Vite assets, and MariaDB 10.11.

```bash
cp u763116450_asTeeFinal.sql docker/mysql-init/01-schema.sql
```

```bash
docker compose up --build
```

Then http://localhost:8000. Full notes in [docker/README.md](../../docker/README.md).

| File | Purpose |
|---|---|
| `Dockerfile` | 3 stages — Node asset build, Composer vendor, Apache runtime |
| `docker-compose.yml` | `app` + `db`, healthchecked, named volumes |
| `docker/entrypoint.sh` | env bootstrap, DB wait, `storage:link`, cache clear |
| `docker/apache/000-default.conf` | vhost with DocumentRoot at `public/` |
| `docker/php/php.ini` | upload limits, opcache, `display_errors=Off` |
| `docker/mysql-init/02-patch.sql` | the columns the production dump predates |
| `.dockerignore` | keeps `.env` and `*.sql` out of image layers |
