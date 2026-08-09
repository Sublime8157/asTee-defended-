# Phase 2c — refactors (containerisation)

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
