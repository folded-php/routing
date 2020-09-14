<?php

declare(strict_types = 1);

use function Folded\redirectToUrl;

it("should return null when using the redirectToUrl function", function (): void {
    expect(redirectToUrl("/"))->toBeNull();
});
