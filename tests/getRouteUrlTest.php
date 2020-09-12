<?php

declare(strict_types = 1);

use function Folded\getRouteUrl;
use function Folded\addGetRoute;

it("should get the URL of the parameterized route", function (): void {
    addGetRoute("/user/{user}", function (): void {
    }, "user.show");

    expect(getRouteUrl("user.show", ["user" => 42]))->toBe("/user/42");
});
