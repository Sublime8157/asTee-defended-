# Phase 2c — files deleted

None. Containerisation was additive.

Effectively neutralised rather than deleted: the root `.htaccess` — with
DocumentRoot at `public/` it is no longer served, so it can no longer expose
`.env` or the SQL dump. It stays on disk for the shared-hosting deploy that
still relies on it; it goes when hosting moves.
