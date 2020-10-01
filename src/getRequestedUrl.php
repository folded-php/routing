<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\getRequestedUrl")) {
    /**
     * Get the requested URL.
     *
     * @since 0.1.0
     *
     * @example
     * getRequestedUrl();
     */
    function getRequestedUrl(): string
    {
        return $_SERVER["REQUEST_URI"];
    }
}
