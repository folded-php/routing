<?php

declare(strict_types = 1);

use function Folded\addGetRoute;
use function Folded\redirectToRoute;
use Folded\Exceptions\RouteNotFoundException;

it("should return null when using the redirectToRoute function", function (): void {
    addGetRoute("/", function (): void {
    }, "home.index");

    expect(redirectToRoute("home.index"))->toBeNull();
});

it("should set proper location header", function(): void {
    addGetRoute("/", function (): void {
    }, "home.index");
    redirectToRoute("home.index");
    $headers = xdebug_get_headers();
    $expectedHeaders = [
        'Location:/'
    ];
    expect($headers)->toEqual($expectedHeaders);
});

it("should add route params", function (): void {

    addGetRoute("/", function (): void {
    }, "home.index");

    redirectToRoute('home.index', 303,
        [
            'user' => 1,
            'test' => 2

        ]
    );
    $headers = xdebug_get_headers();
    expect($headers[0])->toBe('Location:/user/1/test/2');
});

it("should throw exception when route not found", function(): void {
    $this->expectException(RouteNotFoundException::class);
    redirectToRoute('example-not-registered-route');
});
