## Fill this with the files deleted

### Phase 0 — repo hygiene (branch `chore/business-ready-phase-0`)

**Untracked from git, kept on disk**

| File | Why |
|---|---|
| `u763116450_asTeeFinal.sql` | Production dump containing real customer PII — full names, home addresses, contact numbers, email addresses and bcrypt password hashes. Must never be in version control. Kept locally because Phase 3 needs it as the authoritative schema reference. Now matched by `*.sql` in `.gitignore`. |

**Deleted outright**

| File | Lines | Why |
|---|---|---|
| `public/public.zip` | 9.9 MB | Archive committed to the web root and directly downloadable. `public/.htaccess` sets `-Indexes` but does not deny file fetches. |
| `composer.phar` | 2.9 MB | Committed binary. Composer 2.9.5 is installed globally at `/c/ProgramData/ComposerSetup/bin/composer`. |
| `findme` | 1 | Contained the single word `congrats`. No reference anywhere. |
| `resources/views/partial/_Tools.blade.php` | 255 | Dead inline `<script>` duplicate of `public/js/diy.js`. Verified zero references. |
| `resources/views/partial/_Cart.blade.php` | 46 | Orphaned cart markup. Verified zero references. |
| `app/Http/Controllers/adminAccountsController.php` | 16 | Unrouted — `/accounts/pending` goes to `PendingAccountsController`. Only self-reference is its own class declaration. |
| `app/Models/soldProducts.php` | — | Zero references anywhere. Its `$table = 'product_sold'` does not exist in the dump or any migration. |
| `app/Models/customers.php` | — | Zero references. Duplicate Eloquent model over the same `customers` table as `App\Models\User`, with a stale `age` column and `password` in `$fillable` without a hashing cast. |
| `resources/views/welcome.blade.php` | 140 | Untouched Laravel welcome page. Only reference is a commented-out route at `routes/web.php:27`. |
| `webpack.mix.js` | 4 | Laravel Mix config; `laravel-mix` is not installed. The project builds with Vite. |
| `resources/js/fabric.js` | 1 | `window.fabric = require('fabric')` — CommonJS in a `"type": "module"` package, not in Vite's input list. Only referenced by the deleted `webpack.mix.js`. |

**Deliberately NOT deleted** (the plan listed these, verification showed they are live):

| File | Why kept |
|---|---|
| `resources/views/auth/passwords/reset.blade.php`, `userReset.blade.php` | Rendered by `AdminCustomizeResetPasswordController:53` and `UserCustomizeResetPasswordController:53`. |
| `resources/views/layouts/app.blade.php` | Extended by the live reset views above. |
| `app/Http/Controllers/HomeController.php`, `resources/views/user/homepage.blade.php` | `HomeController@index` is routed at `routes/web.php:195` and renders the real storefront homepage. |
| `app/Models/{Genders,Sizes,Status,UserStatus,Variations,productStatus}.php` | Only used by `database/seeders/`. Deleting the models without the seeders breaks `db:seed`. Deferred to Phase 3, where models, seeders and lookup tables are removed together as PHP enums replace them. |

### Phase 2a — route protection

**Deleted — the admin self-registration path** (unauthenticated privilege escalation)

| File | Why |
|---|---|
| `resources/views/admin/registration.blade.php` | The public admin signup form. |
| `resources/views/admin/emailverified.blade.php` | Confirmation page for that flow. |
| `app/Mail/AdminVerificationEmail.php` | Sent the unsigned `verifyAdminRegistration` link. |
| `resources/views/mail/adminVerificationEmail.blade.php` | Its template. |
| `adminIndexController::registerAccount()`, `::submitRegistration()` | The two controller methods. |

Replaced by `php artisan astee:make-admin`.

**Deleted — unrouted laravel/ui controllers**

`LoginController`, `RegisterController`, `ForgotPasswordController`,
`ResetPasswordController`, `ConfirmPasswordController`, `VerificationController`.
All six were reachable only through `Auth::routes()`, which is now removed.
The four `*Customize*` reset controllers are the live ones and remain.

**Deleted — dead Bootstrap scaffold views**

`auth/login.blade.php`, `auth/register.blade.php`, `auth/verify.blade.php`,
`auth/passwords/confirm.blade.php`, `auth/passwords/email.blade.php`,
`home.blade.php`. The real customer login is `login/registration/login.blade.php`.

`auth/passwords/reset.blade.php` (admin) and `userReset.blade.php` (customer)
are kept — they are the live reset forms.

**Deleted — `app/Http/Middleware/cart.php`**

Asserted `session()->has('isLoggedin')` on a single route. That route now uses
the real `auth` middleware.

**Deleted — routes**

| Route | Why |
|---|---|
| `GET /regsiterAccount`, `POST /submitRegistration` | Unauthenticated admin creation. |
| `GET /verifyAdmin/{email}` | Unsigned; verified any admin account by URL. |
| `GET /adminVerified` | Part of the same flow. |
| `Auth::routes()` ×2 | Duplicated, and its `password.reset`/`password.update` names collided with the admin reset controller. Nothing live used them. |
| `GET /updateTable` | `adminOnProcessController::updateTable` does not exist — 500 on every hit. |
| `GET /invoice`, `/newOrder`, `/feedback`, `/passwordResetEmail`, `/emailVerification` | Raw mail templates, publicly reachable. Now registered only in local/development. |
