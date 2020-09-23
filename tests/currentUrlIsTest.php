<?php

declare(strict_types = 1);

use function Folded\currentUrlIs;

it("should return true if the current url is the correct one", function (): void {
    $url = "/";

    $_SERVER["REQUEST_URI"] = $url;

    expect(currentUrlIs($url))->toBeTrue();
});
