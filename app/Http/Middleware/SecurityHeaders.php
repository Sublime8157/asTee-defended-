<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Attach baseline security response headers.
     *
     * The application previously set none of these, in middleware or in
     * .htaccess.
     *
     * No Content-Security-Policy is set yet: the storefront still loads jQuery,
     * fabric.js and Chart.js from three CDNs and relies on inline event handlers
     * and inline <script> blocks, so any useful CSP would need 'unsafe-inline'
     * and would be theatre. Phase 6 moves those to bundled assets, at which
     * point a real policy can be enforced.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // Browser features this storefront never uses.
        $response->headers->set(
            'Permissions-Policy',
            'geolocation=(), microphone=(), camera=(), payment=(), usb=()'
        );

        // HSTS only over TLS — sending it over plain HTTP is meaningless, and
        // pinning localhost to HTTPS would break local development.
        if ($request->secure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        return $response;
    }
}
