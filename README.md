# folded/routing

Routing functions for your web application.

[![Packagist License](https://img.shields.io/packagist/l/folded/routing)](https://github.com/folded-php/routing/blob/master/LICENSE) [![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/folded/routing)](https://github.com/folded-php/routing/blob/master/composer.json#L14) [![Packagist Version](https://img.shields.io/packagist/v/folded/routing)](https://packagist.org/packages/folded/routing) [![Build Status](https://travis-ci.com/folded-php/routing.svg?branch=master)](https://travis-ci.com/folded-php/routing) [![Maintainability](https://api.codeclimate.com/v1/badges/0be9fba0b7990aba814d/maintainability)](https://codeclimate.com/github/folded-php/routing/maintainability) [![TODOs](https://img.shields.io/endpoint?url=https://api.tickgit.com/badge?repo=github.com/folded-php/routing)](https://www.tickgit.com/browse?repo=github.com/folded-php/routing)

## Summary

- [About](#about)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Examples](#examples)
- [Version support](#version-support)

## About

I created this library to have a standalone, fully featured router, and be able to pull it in any project, that have some existing code or not.

Folded is a constellation of packages to help you setting up a web app easily, using ready to plug in packages.

- [folded/action](https://github.com/folded-php/action): A way to organize your controllers for your web app.
- [folded/config](https://github.com/folded-php/config): Configuration utilities for your PHP web app.
- [folded/crypt](https://github.com/folded-php/crypt): Encrypt and decrypt strings for your web app.
- [folded/exception](https://github.com/folded-php/exception): Various kind of exception to throw for your web app.
- [folded/history](https://github.com/folded-php/history): Manipulate the browser history for your web app.
- [folded/http](https://github.com/folded-php/http): HTTP utilities for your web app.
- [folded/orm](https://github.com/folded-php/orm): An ORM for you web app.
- [folded/request](https://github.com/folded-php/request): Request utilities, including a request validator, for your PHP web app.
- [folded/session](https://github.com/folded-php/session): Session functions for your web app.
- [folded/view](https://github.com/folded-php/view): View utilities for your PHP web app.

## Features

- register GET and POST routes actions (using callback)
- can match the current browsed URL and execute the associated callback
- can name the registered route to use additional functions like:
  - getting the URL from a route name

## Requirements

- PHP version 7.4+
- Composer installed

## Installation

- [1. Install the package](1-install-the-package)
- [2. Bootstrap the router](#2-bootstrap-the-router)

### 1. Install the package

On your project root directory, run this command:

```bash
composer require folded/routing
```

### 2. Bootstrap the router

In the script that is called first, register your routes, and then call for `matchRequestedUrl()`:

```php
use function Folded\addGetRoute;
use function Folded\matchRequestedUrl;

addGetRoute("/", function() {
  echo "Hello world";
});

try {
    matchRequestedUrl();
} catch (Exception $exception) {
  // ...
}
```

## Examples

As this library is using [nikic/fast-route](https://github.com/nikic/FastRoute) internally, refer to this documentation to know [all the possibilities](https://github.com/nikic/FastRoute#defining-routes) regarding constructing the route string.

- [1. Register a GET route](#1-register-a-get-route)
- [2. Register a POST route](#2-register-a-post-route)
- [3. Catching url not found exceptions](#3-catching-url-not-found-exceptions)
- [4. Catching method not allowed exceptions](#4-catching-method-not-allowed-exceptions)
- [5. Naming a route](#5-naming-a-route)
- [6. Get the URL of a named route](#6-get-the-url-of-a-named-route)
- [7. Redirect to a named route](#7-redirect-to-a-named-route)
- [8. Redirect to an URL](#8-redirect-to-an-url)

### 1. Register a GET route

In this example, we will register a GET route.

```php
use function Folded\addGetRoute;

addGetRoute("/about-us", function() {
  echo "<h1>About us</h1>";
});
```

### 2. Register a POST route

In this example, we will register a POST route.

```php
use function Folded\addPostRoute;

addPostRoute("/search/{search}", function($search) {
  // Pulling posts from the database...
  echo "<h1>Search result for $search</h1>";
});
```

### 3. Catching url not found exceptions

In this example, we will catch a not found exception.

```php
use function Folded\matchRequestedUrl;
use Folded\Exceptions\UrlNotFoundException;

try {
  matchRequestedUrl();
} catch (Exception $exception) {
  if ($exception instanceof UrlNotFoundException) {
    // Log it, or send it to an error management system...
    // Display a 404 page...
  }
}
```

### 4. Catching method not allowed exceptions

In this example, we will catch a method not allowed error (which happens when you browsed an URL, but this url has been registered with another protocol).

```php
use function Folded\matchRequestedUrl;
use Folded\Exceptions\MethodNotAllowedException;

try {
  matchRequestedUrl();
} catch (Exception $exception) {
  if ($exception instanceof MethodNotAllowedException) {
    // Log it, or send it to an error management system...
    // Display a 405 page...
  }
}
```

### 5. Naming a route

In this example, we will name a route.

```php
use function Folded\addGetRoute;

addGetRoute("/", function() {
  echo "welcome home";
}, "home.index");
```

### 6. Get the URL of a named route

In this example, we will get the name of a named route.

```php
use function Folded\addGetRoute;
use function Folded\getRouteUrl;

addGetRoute("/user/{user}/post/{post}", function($user, $post) {
  echo "User $user posted $post";
}, "user.post.show");

echo getRouteUrl("user.post.show", ["user" => 42, "post" => 1]); // string(15) "/user/42/post/1"
```

### 7. Redirect to a named route

In this example, we will redirect to the URL of a named route.

```php
use function Folded\addGetRoute;
use function Folded\redirectToRoute;

addGetRoute("/about-us", function() {
  echo "<h1>About us</h1>";
}, "about-us.index");

redirectToRoute("about-us.index");
```

By default, a status code `303` will be used alongside the redirection. You can override this behavior by adding the HTTP status code of your choice as second parameter:

```php
use function Folded\addGetRoute;
use function Folded\redirectToRoute;

addGetRoute("/about-us", function() {
  echo "<h1>About us</h1>";
}, "about-us.index");

redirectToRoute("about-us.index", 200);
```

### 8. Redirect to an URL

In this example, we will redirect to a plain URL.

```php
use function Folded\redirectToUrl;

redirectToUrl("/about-us");
```

By default, a status code `303` will be used alongside the redirection. You can override this behavior by adding the HTTP status code of your choice as second parameter:

```php
use function Folded\redirectToUrl;

redirectToUrl("/", 200);
```

## Version support

|        | 7.3 | 7.4 | 8.0 |
| ------ | --- | --- | --- |
| v0.1.0 | ❌  | ✔️  | ❓  |
| v0.1.1 | ❌  | ✔️  | ❓  |
| v0.1.2 | ❌  | ✔️  | ❓  |
| v0.1.3 | ❌  | ✔️  | ❓  |
| v0.2.0 | ❌  | ✔️  | ❓  |
| v0.3.0 | ❌  | ✔️  | ❓  |
| v0.4.0 | ❌  | ✔️  | ❓  |
