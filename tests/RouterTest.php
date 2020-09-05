<?php

declare(strict_types = 1);

use Folded\Router;

beforeEach(function (): void {
    Router::clear();
});

it("should throw an exception if the route is empty", function (): void {
    $this->expectException('InvalidArgumentException');

    Router::addGetRoute("", function (): void {
        echo "hello world";
    });
});

it("should throw an exception if the current URL is not found", function (): void {
    $this->expectException('Khalyomede\Folded\Exceptions\UrlNotFoundException');

    $_SERVER["REQUEST_URI"] = "/about-us";
    $_SERVER["REQUEST_METHOD"] = "GET";

    Router::addGetRoute("/", function (): void {
        echo "hello world";
    });
    Router::startEngine();
    Router::matchRequestedUrl();
});

it("should throw an exception if the current URL method is not allowed", function (): void {
    $this->expectException('Khalyomede\Folded\Exceptions\MethodNotAllowedException');

    $_SERVER["REQUEST_URI"] = "/";
    $_SERVER["REQUEST_METHOD"] = "POST";

    Router::addGetRoute("/", function (): void {
        echo "hello world";
    });
    Router::startEngine();
    Router::matchRequestedUrl();
});

it("should execute the closure if the current URL matches the registered route", function (): void {
    $_SERVER["REQUEST_URI"] = "/";
    $_SERVER["REQUEST_METHOD"] = "GET";

    Router::addGetRoute("/", function () {
        return "hello world";
    });
    Router::startEngine();

    expect(Router::matchRequestedUrl())->toBe("hello world");
});

it("should execute the closure if the current URL has query string and matches the registered route", function (): void {
    $_SERVER["REQUEST_URI"] = "/?utm_source=gmail&utm_medium=email";
    $_SERVER["REQUEST_METHOD"] = "GET";

    Router::addGetRoute("/", function () {
        return "hello world";
    });
    Router::startEngine();

    expect(Router::matchRequestedUrl())->toBe("hello world");
});

it("should execute the closure if the current URL matches the POST route", function (): void {
    $_SERVER["REQUEST_URI"] = "/search";
    $_SERVER["REQUEST_METHOD"] = "POST";

    Router::addPostRoute("/search", function () {
        return "search results";
    });
    Router::startEngine();

    expect(Router::matchRequestedUrl())->toBe("search results");
});

it("should execute the closure if the current URL with query strings matches the POST route", function (): void {
    $_SERVER["REQUEST_URI"] = "/search?tag=laravel";
    $_SERVER["REQUEST_METHOD"] = "POST";

    Router::addPostRoute("/search", function () {
        return "search results";
    });

    expect(Router::matchRequestedUrl())->toBe("search results");
});

it("should pass parameters correctly if the URL matches", function (): void {
    $_SERVER["REQUEST_URI"] = "/post/42";
    $_SERVER["REQUEST_METHOD"] = "GET";

    Router::addGetRoute("/post/{id}", function ($id) {
        return "showing post #$id";
    });

    expect(Router::matchRequestedUrl())->toBe("showing post #42");
});
