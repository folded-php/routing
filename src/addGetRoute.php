<?php

declare(strict_types = 1);

namespace Folded;

use Closure;

if (!function_exists("addGetRoute")) {
    /**
     * Add a GET route.
     *
     * @param string  $route  The URL or route pattern.
     * @param Closure $action The function to trigger when the current browsed URL matches.
     *
     * @since 0.1.0
     *
     * @example
     * addGetRoute("/", function() {
     *  echo "<h1>Welcome</h1>";
     * });
     */
    function addGetRoute(string $route, Closure $action): void
    {
        Router::addGetRoute($route, $action);
    }
}
