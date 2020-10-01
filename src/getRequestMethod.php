<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\getRequestedMethod")) {
    /**
     * Get the requested HTTP protocol.
     *
     * @since 0.1.0
     *
     * @example
     * getRequestedMethod();
     */
    function getRequestedMethod(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }
}
