<?php

declare(strict_types = 1);

namespace Folded;

use Folded\Exceptions\UrlNotFoundException;
use Folded\Exceptions\MethodNotAllowedException;

if (!function_exists("Folded\matchRequestedUrl")) {
    /**
     * Register route and try to match the current browsed URL.
     *
     * @since 0.1.0
     *
     * @throws UrlNotFoundException      If the URL is not found in the registered routes.
     * @throws MethodNotAllowedException If the URL has been found, but the current protocol does not match.
     *
     * @return mixed
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
