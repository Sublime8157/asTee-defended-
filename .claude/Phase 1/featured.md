# Phase 1 — features

No user-facing features. Phase 1 was a framework upgrade.

Developer-facing changes worth knowing:

**Tests no longer hit the production database.** `phpunit.xml` now really uses
in-memory SQLite — the env lines were previously commented out, so the suite ran
against whatever `.env` pointed at.

```bash
vendor/bin/phpunit
```

**Build surface shrank.** `npm run build` still drives `resources/css/app.css` and
`resources/js/app.js` via Vite, but from 10 declared packages instead of ~90.

```bash
npm ci && npm run build
```
