# Phase 0 — Repo hygiene & exposure

Status: ✅ done · Branch `chore/business-ready-phase-0`

- Branched off `main`; pre-existing working-tree changes preserved in a baseline commit.
- Untracked the PII database dump; kept on disk as the Phase 3 schema reference.
- Removed 9.9 MB `public.zip` and 2.9 MB `composer.phar` from the repo.
- Deleted 11 verified-dead files (~470 lines). See [deleted.md](deleted.md).
- Created `.env.example` — the project previously could not be bootstrapped without the original `.env`.
- Verified and **rejected** 5 deletions the plan proposed: the password-reset views,
  `layouts/app.blade.php` and `HomeController` are all live.

## Outstanding — needs the owner, not code

1. **Git history purge.** The PII dump is untracked but still present in every
   historical commit. `git filter-repo` is not installed; needs
   `pip install git-filter-repo`. The rewrite is destructive and requires a
   force-push to `github.com/Sublime8157/asTee-defended-`. Not run yet — waiting
   on confirmation.
2. **Credential rotation.** The bcrypt hashes in the dump were publicly readable
   for as long as the repo was public. Every account in it should be treated as
   compromised and forced through a password reset. Separately, the live
   Hostinger SMTP password sits in plaintext in `.env` — it was never committed,
   but it should be rotated as routine hygiene.
