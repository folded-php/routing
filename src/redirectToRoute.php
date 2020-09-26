<?php

declare(strict_types = 1);

namespace Folded;

use Http\Redirection;

if (!function_exists("redirectToRoute")) {
    /**
     * Redirects to the URL found by its route name.
     *
     * @param string $name   The name of the route.
     * @param int    $status The HTTP status code to use when redirecting (default: 303 - See other).
     *
     * @throws RouteNotFoundException If the route name is not found.
     *
     * @since 0.3.0
     *
     * @example
     * addGetRoute("/", function() {}, "home.index");
     *
     * redirectToRoute("home.index"); // redirects to "/"
     */
    function redirectToRoute(string $name, int $status = Redirection::SEE_OTHER, array $routeParams = []): void
    {
        Router::redirectToRoute($name, $status, $routeParams);
    }
}
