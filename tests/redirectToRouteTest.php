<?php

declare(strict_types = 1);

use function Folded\addGetRoute;
use function Folded\redirectToRoute;

it("should return null when using the redirectToRoute function", function (): void {
    addGetRoute("/", function (): void {
    }, "home.index");

    expect(redirectToRoute("home.index"))->toBeNull();
});
