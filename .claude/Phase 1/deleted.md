# Phase 1 — files & dependencies deleted

## Dependencies

| Package | Why |
|---|---|
| `guzzle/guzzle ^3.8` | Abandoned since 2015, unused by any code in the repo. |
| `spatie/laravel-ignition` | Not part of the L11+ slim skeleton; also removes its three `_ignition/*` routes. |
| `fabric-history` | Pins `fabric <7`, bundled into `app.js`, never called — `diy.js` hand-rolls its own undo/redo. |
| ~80 hand-listed transitive npm deps | `package.json` `dependencies` had Tailwind's whole transitive tree copied in. Reduced to the 4 real imports + 6 build tools. |

## Framework files removed by the slim skeleton

`app/Http/Kernel.php`, `app/Console/Kernel.php`, `app/Exceptions/Handler.php`,
4 providers (`AppServiceProvider` kept), and 9 stock middleware verified
byte-identical to the framework's own copies:

`TrustProxies`, `TrustHosts`, `PreventRequestsDuringMaintenance`,
`EncryptCookies`, `VerifyCsrfToken`, `TrimStrings`, `ConvertEmptyStringsToNull`,
`Authenticate`, `RedirectIfAuthenticated`.

Replaced by `bootstrap/app.php` + `bootstrap/providers.php`. The one
behavioural difference — `RedirectIfAuthenticated`'s `RouteServiceProvider::HOME`
— was preserved as `redirectUsersTo('/home')`.
