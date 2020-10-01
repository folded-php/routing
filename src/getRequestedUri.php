<?php

declare(strict_types = 1);

namespace Foled;

use function Folded\getRequestedUrl;

if (!function_exists("Folded\getRequestedUri")) {
    /**
     * Get the requested URI.
     *
     * @since 0.1.0
     *
     * @example
     * getRequestedUri();
     */
    function getRequestedUri(): string
    {
        $uri = getRequestedUrl();
        $pos = mb_strpos($uri, "?");

        if ($pos !== false) {
            $uri = mb_substr($uri, 0, $pos);
        }

        return rawurldecode($uri);
    }
}
