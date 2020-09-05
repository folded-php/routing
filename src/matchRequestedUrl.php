<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("matchRequestedUrl")) {
    function matchRequestedUrl()
    {
        Router::startEngine();

        return Router::matchRequestedUrl();
    }
}
