<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\getRouteUrl")) {
    /**
     * Get the URL associated with the given route.
     * If the route contains placeholders, you need to pass the parameters to be filled.
     *
     * @param string $name       The name of the route.
     * @param array  $parameters The parameters, by key-value pairs or simply values, to fill in the placeholders (optional).
     *
     * @throws OurOfRangeException If the route name is not found.
     *
     * @since 0.2.0
     *
     * @example
     * Router::getRouteUrl("user.show", ["user" => 42]);
     */
    function getRouteUrl(string $name, array $parameters = []): string
    {
        return Router::getRouteUrl($name, $parameters);
    }
}
