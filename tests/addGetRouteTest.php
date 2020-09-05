<?php

declare(strict_types = 1);

use Folded\Router;
use function Folded\getRoutes;
use function Folded\addGetRoute;

beforeEach(function (): void {
    Router::clear();
});

it("should add the route", function (): void {
    addGetRoute("/", function (): void {
        echo "hello world";
    });

    $firstRoute = getRoutes()[0];

    expect($firstRoute->getRoute())->toBe("/");
    expect($firstRoute->getProtocol())->toBe("GET");
});

it("should throw an exception if the route is empty", function (): void {
    $this->expectException('InvalidArgumentException');

    addGetRoute("", function (): void {
        echo "hello world";
    });
});

it("should throw an exception message if the route is empty", function (): void {
    $this->expectExceptionMessage("route is empty");

    addGetRoute("", function (): void {
        echo "hello world";
    });
});
