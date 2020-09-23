<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("currentUrlIs")) {
    /**
     * Returns true if the URL matches the current URL, else returns false.
     *
     * @param string $url The URL to verify.
     *
     * @throws InvalidArgumentException If the URL is empty.
     *
     * @since 0.5.0
     *
     * @example
     * if (currentUrlIs("/")) {
     *  echo "current URL is /";
     * } else {
     *  echo "current URL is not "/";
     * }
     */
    function currentUrlIs(string $url): bool
    {
        return Router::currentUrlIs($url);
    }
}
