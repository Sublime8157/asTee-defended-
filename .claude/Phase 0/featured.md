# Phase 0 — features

No user-facing features. Phase 0 was hygiene and exposure work only.

Developer-facing addition:

**`.env.example`** — the project can now be bootstrapped without the original
`.env`. Placeholders cover the current keys plus the ones later phases need
(`SESSION_SECURE_COOKIE`, `PAYMONGO_*`, `SHIPPING_FEE`, `MAIL_*_ADDRESS`).

```bash
cp .env.example .env
php artisan key:generate
```
