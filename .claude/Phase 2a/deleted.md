# Phase 2a — files & routes deleted

## The admin self-registration path (unauthenticated privilege escalation)

| File | Why |
|---|---|
| `resources/views/admin/registration.blade.php` | The public admin signup form. |
| `resources/views/admin/emailverified.blade.php` | Confirmation page for that flow. |
| `app/Mail/AdminVerificationEmail.php` | Sent the unsigned `verifyAdminRegistration` link. |
| `resources/views/mail/adminVerificationEmail.blade.php` | Its template. |
| `adminIndexController::registerAccount()`, `::submitRegistration()` | The two controller methods. |

Replaced by `php artisan astee:make-admin`.

## Unrouted laravel/ui controllers

`LoginController`, `RegisterController`, `ForgotPasswordController`,
`ResetPasswordController`, `ConfirmPasswordController`, `VerificationController`.
All six were reachable only through `Auth::routes()`, which is now removed.
The four `*Customize*` reset controllers are the live ones and remain.

## Dead Bootstrap scaffold views

`auth/login.blade.php`, `auth/register.blade.php`, `auth/verify.blade.php`,
`auth/passwords/confirm.blade.php`, `auth/passwords/email.blade.php`,
`home.blade.php`. The real customer login is `login/registration/login.blade.php`.

`auth/passwords/reset.blade.php` (admin) and `userReset.blade.php` (customer)
are kept — they are the live reset forms.

## `app/Http/Middleware/cart.php`

Asserted `session()->has('isLoggedin')` on a single route. That route now uses
the real `auth` middleware.

## Routes

| Route | Why |
|---|---|
| `GET /regsiterAccount`, `POST /submitRegistration` | Unauthenticated admin creation. |
| `GET /verifyAdmin/{email}` | Unsigned; verified any admin account by URL. |
| `GET /adminVerified` | Part of the same flow. |
| `Auth::routes()` ×2 | Duplicated, and its `password.reset`/`password.update` names collided with the admin reset controller. Nothing live used them. |
| `GET /updateTable` | `adminOnProcessController::updateTable` does not exist — 500 on every hit. |
| `GET /invoice`, `/newOrder`, `/feedback`, `/passwordResetEmail`, `/emailVerification` | Raw mail templates, publicly reachable. Now registered only in local/development. |
