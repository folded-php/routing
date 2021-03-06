<?php

declare(strict_types = 1);

use Folded\Router;
use Folded\Exceptions\UrlNotFoundException;
use Folded\Exceptions\RouteNotFoundException;
use Folded\Exceptions\MethodNotAllowedException;

beforeEach(function (): void {
    Router::clear();
});

it("should throw an exception if the route is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    Router::addGetRoute("", function (): void {
        echo "hello world";
    });
});

it("should throw an exception if the current URL is not found", function (): void {
    $this->expectException(UrlNotFoundException::class);

    $_SERVER["REQUEST_URI"] = "/about-us";
    $_SERVER["REQUEST_METHOD"] = "GET";

    Router::addGetRoute("/", function (): void {
        echo "hello world";
    });
    Router::startEngine();
    Router::matchRequestedUrl();
});

it("should set the url in the exception if the current URL is not found", function (): void {
    $_SERVER["REQUEST_URI"] = "/about-us";
    $_SERVER["REQUEST_METHOD"] = "GET";

    Router::addGetRoute("/", function (): void {
        echo "hello world";
    });
    Router::startEngine();

    try {
        Router::matchRequestedUrl();
    } catch (UrlNotFoundException $exception) {
        expect($exception->getUrl())->toBe("/about-us");
    }
});

it("should throw an exception if the current URL method is not allowed", function (): void {
    $this->expectException(MethodNotAllowedException::class);

    $_SERVER["REQUEST_URI"] = "/";
    $_SERVER["REQUEST_METHOD"] = "POST";

    Router::addGetRoute("/", function (): void {
        echo "hello world";
    });
    Router::startEngine();
    Router::matchRequestedUrl();
});

it("should set the method not allowed in the exception if the current URL method is not allowed", function (): void {
    $_SERVER["REQUEST_URI"] = "/";
    $_SERVER["REQUEST_METHOD"] = "POST";

    Router::addGetRoute("/", function (): void {
        echo "hello world";
    });
    Router::startEngine();

    try {
        Router::matchRequestedUrl();
    } catch (MethodNotAllowedException $exception) {
        expect($exception->getMethodNotAllowed())->toBe("POST");
    }
});

it("should set the allowed methods in the exception if the current URL method is not allowed", function (): void {
    $_SERVER["REQUEST_URI"] = "/";
    $_SERVER["REQUEST_METHOD"] = "POST";

    Router::addGetRoute("/", function (): void {
        echo "hello world";
    });
    Router::startEngine();

    try {
        Router::matchRequestedUrl();
    } catch (MethodNotAllowedException $exception) {
        expect($exception->getAllowedMethods())->toBe(["GET"]);
    }
});

it("should set the url in the exception if the current URL method is not allowed", function (): void {
    $url = "/";
    $_SERVER["REQUEST_URI"] = $url;
    $_SERVER["REQUEST_METHOD"] = "POST";

    Router::addGetRoute($url, function (): void {
        echo "hello world";
    });
    Router::startEngine();

    try {
        Router::matchRequestedUrl();
    } catch (MethodNotAllowedException $exception) {
        expect($exception->getUrl())->toBe($url);
    }
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

it("should get an URL by the route name", function (): void {
    Router::addGetRoute("/about-us", function (): void {
    }, "about-us.index");

    expect(Router::getRouteUrl("about-us.index"))->toBe("/about-us");
});

it("should get an URL by its route name even if it has parameters, and parameters are filled by index", function (): void {
    Router::addGetRoute("/user/{user}/post/{post}", function (): void {
    }, "user.post.show");

    expect(Router::getRouteUrl("user.post.show", [1, 42]))->toBe("/user/1/post/42");
});

it("should get an URL by its route name even if it has parameters, and parameters are filled by key name", function (): void {
    Router::addGetRoute("/user/{user}/post/{post}", function (): void {
    }, "user.post.show");

    expect(Router::getRouteUrl("user.post.show", ["user" => 1, "post" => 42]))->toBe("/user/1/post/42");
});

it("should get an URL by its route name event if it has parameters, and parameters are filled by key name and index", function (): void {
    Router::addGetRoute("/user/{user}/post/{post}", function (): void {
    }, "user.post.show");

    expect(Router::getRouteUrl("user.post.show", ["user" => 1, 42]))->toBe("/user/1/post/42");
});

it("should get the URL of a parameterized POST route", function (): void {
    Router::addPostRoute("/user/{user}/post", function (): void {
    }, "user.post.store");

    expect(Router::getRouteUrl("user.post.store", ["user" => 42]))->toBe("/user/42/post");
});

it("should throw an exception if the route name does not exist", function (): void {
    $this->expectException(OutOfRangeException::class);

    Router::getRouteUrl("home.index");
});

it("should throw an exception if the route name is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    Router::addGetRoute("/", function (): void {
    }, "");
});

it("should throw an exception if one of the parameter is missing", function (): void {
    $this->expectException(InvalidArgumentException::class);

    Router::addGetRoute("/user/{user}/post/{post}", function (): void {
    }, "user.post.show");

    Router::getRouteUrl("user.post.show", ["user" => 42]);
});

it("should throw an exception message if one of the parameter is missing", function (): void {
    $this->expectExceptionMessage("parameter post missing for route /user/{user}/post/{post}");

    Router::addGetRoute("/user/{user}/post/{post}", function (): void {
    }, "user.post.show");

    Router::getRouteUrl("user.post.show", ["user" => 42]);
});

it("should throw an exception if the parameter does not match the regexp", function (): void {
    $this->expectException(InvalidArgumentException::class);

    Router::addGetRoute("/user/{user}", function (): void {
    }, "user.show");

    Router::getRouteUrl("user.show", ["/42"]);
});

it("should throw an exception message if the parameter does not match the regexp", function (): void {
    $this->expectExceptionMessage("parameter user does not matches regular expression [^/]+ for route /user/{user}");

    Router::addGetRoute("/user/{user}", function (): void {
    }, "user.show");

    echo Router::getRouteUrl("user.show", ["/42"]);
});

it("should raise an exception if the route name is not found", function (): void {
    $this->expectException(RouteNotFoundException::class);

    Router::redirectToRoute("home.index");
});

it("should raise an exception message if the route name is not found", function (): void {
    $this->expectExceptionMessage("route home.index not found");

    Router::redirectToRoute("home.index");
});

it("should set the route in the exception if the route name is not found", function (): void {
    $route = "home.index";

    try {
        Router::redirectToRoute($route);
    } catch (RouteNotFoundException $exception) {
        expect($exception->getRoute())->toBe($route);
    }
});

it("should return null when redirecting to a route", function (): void {
    Router::addGetRoute("/", function (): void {
    }, "home.index");

    expect(Router::redirectToRoute("home.index"))->toBeNull();
});

it("should return null when redirecting to an url", function (): void {
    expect(Router::redirectToUrl("/"))->toBeNull();
});

it("should return true if the current route matches the current URL", function (): void {
    $_SERVER["REQUEST_URI"] = "/";
    $_SERVER["REQUEST_METHOD"] = "GET";

    Router::addGetRoute("/", function (): void {
    }, "home.index");

    expect(Router::currentRouteIs("home.index"))->toBeTrue();
});

it("should return true even if the current route contains query string", function (): void {
    $_SERVER["REQUEST_URI"] = "/?utm_source=slack";

    Router::addGetRoute("/", function (): void {
    }, "home.index");

    expect(Router::currentRouteIs("home.index"))->toBeTrue();
});

it("should return false if the current route does not matches the current URL", function (): void {
    $_SERVER["REQUEST_URI"] = "/";

    Router::addGetRoute("/about-us", function (): void {
    }, "about-us.index");

    expect(Router::currentRouteIs("about-us.index"))->toBeFalse();
});

it("should return true if the current parameterized route matches the current URL", function (): void {
    $_SERVER["REQUEST_URI"] = "/user/42/post/24/edit";

    Router::addGetRoute("/user/{user}/post/{post}/edit", function (): void {
    }, "user.post.edit");

    expect(Router::currentRouteIs("user.post.edit", ["user" => 42, "post" => 24]))->toBeTrue();
});

it("should throw an exception if checking if the current route matches the URL with an unregistered route", function (): void {
    $this->expectException(RouteNotFoundException::class);

    Router::currentRouteIs("not-found.index");
});

it("should throw an exception message if checking if the current route matches the URL with an unregistered route", function (): void {
    $route = "not-found.index";

    $this->expectExceptionMessage("route $route not found");

    Router::currentRouteIs($route);
});

it("should set the route in the exception if checking if the current route matches the URL with an unregistered route", function (): void {
    $route = "not-found.index";

    try {
        Router::currentRouteIs($route);
    } catch (RouteNotFoundException $exception) {
        expect($exception->getRoute())->toBe($route);
    }
});

it("should return true if the current url is the requested one", function (): void {
    $url = "/about-us";

    $_SERVER["REQUEST_URI"] = $url;

    expect(Router::currentUrlIs($url))->toBeTrue();
});

it("should return false if the current url is the requested one", function (): void {
    $_SERVER["REQUEST_URI"] = "/about-us";

    expect(Router::currentUrlIs("/"))->toBeFalse();
});

it("should throw an exception if the current url is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    Router::currentUrlIs("");
});

it("should throw an exception message if the current url is empty", function (): void {
    $this->expectExceptionMessage("url must not be empty");

    Router::currentUrlIs("");
});
