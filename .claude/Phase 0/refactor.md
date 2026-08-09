# Phase 0 — refactors

**`.gitignore` — added `*.sql`, `composer.phar`, `*.zip`**

The repo tracked a production database dump with live customer PII and bcrypt
hashes. Ignoring the file is not enough on its own — it is still reachable in
git history — but it stops the bleeding while the history rewrite is scheduled.
`!database/**/*.sql` keeps the door open for legitimate schema fixtures.

*Why a blanket `*.sql` over naming the one file:* the failure mode being
prevented is "someone drops another dump in the project root". Naming a single
file only prevents the mistake that already happened.

**`.env.example` — created**

The project had none, so it could not be bootstrapped by anyone without the
original `.env`. Added with placeholders plus the keys later phases need:
`SESSION_SECURE_COOKIE`, `PAYMONGO_*`, `SHIPPING_FEE`, and the three
`MAIL_*_ADDRESS` values that are currently hardcoded in controllers
(`adminIndexController:50`, `UserController:252`, `ContactUsController:23`).

`QUEUE_CONNECTION` defaults to `database` rather than `sync`, ahead of Phase 4
moving mail off the request thread.

**Deferred from the plan: lookup-model deletion**

The plan had Phase 0 deleting `Genders`, `Sizes`, `Status`, `UserStatus`,
`Variations` and `productStatus`. Verification showed each is referenced by
`database/seeders/multipleSeeder.php` and friends. Deleting the models while
the seeders still call `Model::insert()` breaks `php artisan db:seed`, which
violates the rule that every phase leaves the app runnable.

*Decision — defer over delete-and-patch:* patching the seeders now means
writing seeder code that Phase 3 immediately throws away when the lookup tables
become PHP backed enums. Deferring costs nothing and keeps the change coherent:
models, seeders and tables all go in one commit.
