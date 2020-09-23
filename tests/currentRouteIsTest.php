<?php

declare(strict_types = 1);

use function Folded\addGetRoute;
use function Folded\currentRouteIs;

it("should return true if the current route is the correct one", function (): void {
    $route = "about-us.index";
    $url = "/about-us";
    $_SERVER["REQUEST_URI"] = $url;

    addGetRoute($url, function (): void {
    }, $route);

    expect(currentRouteIs($route))->toBeTrue();
});
