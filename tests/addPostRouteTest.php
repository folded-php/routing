<?php

declare(strict_types = 1);

use Folded\Router;
use function Folded\getRoutes;
use function Folded\addPostRoute;

beforeEach(function (): void {
    Router::clear();
});

it("should register the route", function (): void {
    addPostRoute("/search", function (): void {
        echo "hello world";
    });

    $firstRoute = getRoutes()[0];

    expect($firstRoute->getRoute())->toBe("/search");
    expect($firstRoute->getProtocol())->toBe("POST");
});

it("should throw an exception if the route is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    addPostRoute("", function (): void {
        echo "hello world";
    });
});

it("should throw an exception message if the route is empty", function (): void {
    $this->expectExceptionMessage("route is empty");

    addPostRoute("", function (): void {
        echo "hello world";
    });
});
