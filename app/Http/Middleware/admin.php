<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    /**
     * Gate a request behind a genuinely authenticated admin.
     *
     * This previously asserted only `session()->has('adminLoggedIn')` — a bare
     * boolean. It never consulted the admin guard, so it could not tell whether
     * the account still existed, was still verified, or had been deleted since
     * the flag was written.
     *
     * adminIndexController::adminLogin already calls
     * auth()->guard('admin')->attempt(), so the guard session is established at
     * login and this is a strictly stronger check with no behaviour change for
     * legitimate admins.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('admin')->check()) {
            return redirect()->route('loginAdmin');
        }

        return $next($request);
    }
}
