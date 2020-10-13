<?php

declare(strict_types = 1);

namespace Folded;

use Closure;
use InvalidArgumentException;

if (!function_exists("Folded\addGetRoute")) {
    /**
     * Add a GET route.
     *
     * @param string  $route  The URL or route pattern.
     * @param Closure $action The function to trigger when the current browsed URL matches.
     * @param string  $name   The name of the route (optional).
     *
     * @throws InvalidArgumentException If the route name is empty.
     *
     * @since 0.1.0
     *
     * @example
     * addGetRoute("/", function() {
     *  echo "<h1>Welcome</h1>";
     * });
     */
    function addGetRoute(string $route, Closure $action, ?string $name = null): void
    {
        Router::addGetRoute($route, $action, $name);
    }
}
