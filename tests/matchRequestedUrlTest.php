<?php

declare(strict_types = 1);

use function Folded\addGetRoute;
use function Folded\matchRequestedUrl;
use Folded\Exceptions\UrlNotFoundException;
use Folded\Exceptions\MethodNotAllowedException;

it("should throw an exception if the route is not found", function (): void {
    $this->expectException(UrlNotFoundException::class);

    matchRequestedUrl();
});

it("should throw an exception if the current browsed method is not allowed but the route match", function (): void {
    $this->expectException(MethodNotAllowedException::class);

    $_SERVER["REQUEST_URI"] = "/";
    $_SERVER["REQUEST_METHOD"] = "POST";

    addGetRoute("/", function (): void {
        echo "hello world";
    });

    matchRequestedUrl();
});

it("should throw an exception if there is an error in the callback", function (): void {
    $this->expectException(Exception::class);

    $_SERVER["REQUEST_URI"] = "/";
    $_SERVER["REQUEST_METHOD"] = "GET";

    addGetRoute("/", function (): void {
        $posts = Post::all(); // Class Post not found
    });

    matchRequestedUrl();
});
