<?php

declare(strict_types = 1);

use Folded\RequestMethod;

it("should return true if the method is GET", function (): void {
    expect(RequestMethod::isValid("GET"))->toBe(true);
});

it("should return true if the method is GET (in lowercase)", function (): void {
    expect(RequestMethod::isValid("get"))->toBe(true);
});

it("should return true if the method is POST", function (): void {
    expect(RequestMethod::isValid("POST"))->toBe(true);
});

it("should return true if the method is POST (in lowercase)", function (): void {
    expect(RequestMethod::isValid("post"))->toBe(true);
});
