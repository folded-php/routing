<?php

declare(strict_types = 1);

use Folded\Route;

it("should set the protocol", function (): void {
    $protocol = "GET";
    $route = new Route($protocol, "/", function (): void {
        echo "hello world";
    });

    expect($route->getProtocol())->toBe($protocol);
});

it("should set the route", function (): void {
    $url = "/";
    $route = new Route("GET", $url, function (): void {
        echo "hello world";
    });

    expect($route->getRoute())->toBe($url);
});

it("should set the action", function (): void {
    $action = function (): void {
        echo "hello world";
    };
    $route = new Route("GET", "/", $action);

    expect($route->getAction())->toBe($action);
});

it("should return true if the route is correct", function (): void {
    expect(Route::isValid("/"))->toBe(true);
});

it("should throw an exception if the protocol is not valid", function (): void {
    $this->expectException(InvalidArgumentException::class);

    new Route("FOO", "/", function (): void {
        echo "hello world";
    });
});

it("should throw an exception message if the protocol is not valid", function (): void {
    $protocol = "FOO";

    $this->expectExceptionMessage("protocol $protocol is not valid");

    new Route($protocol, "/", function (): void {
        echo "hello world";
    });
});

it("should throw an exception if the route is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    new Route("GET", "", function (): void {
        echo "hello world";
    });
});

it("should throw an exception message if the route is empty", function (): void {
    $this->expectExceptionMessage("route is empty");

    new Route("GET", "", function (): void {
        echo "hello world";
    });
});
