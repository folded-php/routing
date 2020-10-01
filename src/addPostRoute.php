<?php

declare(strict_types = 1);

namespace Folded;

use Closure;

if (!function_exists("Folded\addPostRoute")) {
    /**
     * Add a POST route.
     *
     * @param string  $route  The URL or route pattern.
     * @param Closure $action The function to trigger when the current browsed URL matches.
     *
     * @since 0.1.0
     *
     * @example
     * addPostRoute("/search/{search}", function($search) {
     *  echo "<h1>Search results for $search</h1>";
     * });
     */
    function addPostRoute(string $route, Closure $action, ?string $name = null): void
    {
        Router::addPostRoute($route, $action, $name);
    }
}
