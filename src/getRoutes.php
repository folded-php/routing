<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\getRoutes")) {
    /**
     * Returns the registered routes.
     *
     * @since 0.1.0
     *
     * @example
     * $routes = getRoutes();
     *
     * foreach ($routes as $route) {
     *  echo "route: {$route->getRoute()}";
     *  echo "protocol: {$route->getProtocol()}";
     *
     *  $callable = $route->getAction();
     * }
     */
    function getRoutes(): array
    {
        return Router::getRoutes();
    }
}
