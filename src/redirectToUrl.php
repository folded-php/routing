<?php

declare(strict_types = 1);

namespace Folded;

use Http\Redirection;

if (!function_exists("redirectToUrl")) {
    /**
     * Redirects to a given URL.
     *
     * @param int $status The HTTP status code ot use when redirecting.
     *
     * @since 0.3.0
     *
     * @example
     * redirectToUrl("/about-us");
     */
    function redirectToUrl(string $name, int $status = Redirection::SEE_OTHER): void
    {
        Router::redirectToUrl($name, $status);
    }
}
