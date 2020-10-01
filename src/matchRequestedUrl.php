<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\matchRequestedUrl")) {
    /**
     * Register route and try to match the current browsed URL.
     *
     * @since 0.1.0
     *
     * @throws Folded\Exceptions\UrlNotFoundException      If the URL is not found in the registered routes.
     * @throws Folded\Exceptions\MethodNotAllowedException If the URL has been found, but the current protocol does not match.
     *
     * @example
     * matchRequestedUrl();
     */
    function matchRequestedUrl()
    {
        Router::startEngine();

        return Router::matchRequestedUrl();
    }
}
