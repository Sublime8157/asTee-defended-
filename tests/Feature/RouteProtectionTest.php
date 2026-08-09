<?php

namespace Tests\Feature;

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Guards the fix for the headline finding of the security review: 48 of 51
 * state-mutating routes had no auth middleware. `middleware('admin')` was
 * attached to eight GET display pages only, so every admin write — create,
 * edit and delete products, block and delete customers, approve ID documents,
 * delete payment records — was reachable by an anonymous visitor.
 *
 * These tests walk the live route table rather than a hardcoded list, so a
 * route added later without middleware fails the suite instead of shipping.
 */
class RouteProtectionTest extends TestCase
{
    /** Substitute a throwaway value for any {param} in a URI. */
    private function uriFor(RoutingRoute $route): string
    {
        return '/'.ltrim(preg_replace('/\{[^}]+\}/', '1', $route->uri()), '/');
    }

    /** @return array<int, RoutingRoute> */
    private function routesWithMiddleware(string $middleware): array
    {
        return array_values(array_filter(
            Route::getRoutes()->getRoutes(),
            fn (RoutingRoute $route) => in_array($middleware, $route->gatherMiddleware(), true)
        ));
    }

    public function test_admin_middleware_covers_every_admin_controller_route(): void
    {
        // Any route pointing at an admin-only controller must carry the guard.
        $adminControllers = [
            'AdminProductController',
            'AdminOrderItemController',
            'AdminFileController',
            'accountsController',
            'blockedAccountsController',
            'PendingAccountsController',
            'dashboardController',
            'OrderHistoryController',
            'PaymentHistoryController',
            'SalesHistoryController',
        ];

        $unguarded = [];

        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getActionName();

            foreach ($adminControllers as $controller) {
                if (str_contains($action, $controller)
                    && ! in_array('admin', $route->gatherMiddleware(), true)) {
                    $unguarded[] = implode('|', $route->methods()).' '.$route->uri();
                }
            }
        }

        $this->assertSame([], $unguarded,
            "These admin routes are missing the 'admin' middleware:\n".implode("\n", $unguarded));
    }

    public function test_guests_cannot_reach_any_admin_route(): void
    {
        $routes = $this->routesWithMiddleware('admin');

        // Fail loudly rather than passing vacuously if the grouping is lost.
        $this->assertGreaterThan(50, count($routes),
            'Expected the admin group to cover the whole admin panel.');

        $reachable = [];

        foreach ($routes as $route) {
            $method = $route->methods()[0];

            if ($method === 'HEAD') {
                continue;
            }

            $response = $this->call($method, $this->uriFor($route));

            // The guard must bounce guests to the admin login. Any other
            // outcome means the request reached the controller.
            if ($response->headers->get('Location') !== url('/loginAdmin')) {
                $reachable[] = $method.' '.$route->uri().' -> '.$response->status()
                    .' '.($response->headers->get('Location') ?? 'no redirect');
            }
        }

        $this->assertSame([], $reachable,
            "Guests reached these admin routes:\n".implode("\n", $reachable));
    }

    public function test_guests_cannot_reach_authenticated_customer_routes(): void
    {
        $routes = $this->routesWithMiddleware('auth');

        $this->assertGreaterThan(10, count($routes),
            'Expected the customer group to cover profile, cart and purchases.');

        $reachable = [];

        foreach ($routes as $route) {
            $method = $route->methods()[0];

            if ($method === 'HEAD') {
                continue;
            }

            $response = $this->call($method, $this->uriFor($route));

            // Guests are sent to the storefront login at '/'.
            if ($response->headers->get('Location') !== url('/')) {
                $reachable[] = $method.' '.$route->uri().' -> '.$response->status()
                    .' '.($response->headers->get('Location') ?? 'no redirect');
            }
        }

        $this->assertSame([], $reachable,
            "Guests reached these customer routes:\n".implode("\n", $reachable));
    }

    public function test_self_service_admin_registration_is_gone(): void
    {
        // Two unauthenticated requests used to be enough to obtain a verified
        // admin account: POST /submitRegistration then GET /verifyAdmin/{email}.
        foreach (['/regsiterAccount', '/verifyAdmin/attacker@example.com'] as $uri) {
            $this->get($uri)->assertNotFound();
        }

        $this->post('/submitRegistration', [
            'email' => 'attacker@example.com',
            'username' => 'attacker',
            'password' => 'Sup3rSecret!pass',
        ])->assertNotFound();
    }

    public function test_email_verification_requires_a_valid_signature(): void
    {
        // /emailVerified/{email} previously set email_verified_at for whatever
        // address appeared in the URL, with no signature and no token.
        $this->get('/emailVerified/someone@example.com')->assertForbidden();
    }

    public function test_mail_template_previews_are_not_registered_outside_development(): void
    {
        // These render raw mail templates and were publicly reachable in
        // production with no middleware. They are now registered only when
        // the environment is local/development — the test environment is not.
        $uris = collect(Route::getRoutes()->getRoutes())
            ->map(fn (RoutingRoute $route) => $route->uri())
            ->all();

        foreach (['invoice', 'newOrder', 'feedback', 'passwordResetEmail', 'emailVerification'] as $uri) {
            $this->assertNotContains($uri, $uris,
                "/{$uri} should not be registered outside local development.");
        }
    }
}
