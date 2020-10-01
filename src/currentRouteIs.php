<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\currentRouteIs")) {
    /**
     * Returns true if route matches the current URL, else returns false.
     *
     * @param string $route      The route name to verify.
     * @param array  $parameters The parameters to pass to the route if it has named parameters.
     *
     * @throws Folded\Exceptions\RouteNotFoundException If the route name is not found.
     *
     * @since 0.5.0
     *
     * @example
     * if (currentRouteIs("home.index")) {
     *  echo "current route is /";
     * } else {
     *  echo "current route is not /";
     * }
     */
    function currentRouteIs(string $route, array $parameters = []): bool
    {
        return Router::currentRouteIs($route, $parameters);
    }
}
