# folded/routing

Routing functions for your web application.

## Summary

-   [About](#about)
-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Examples](#examples)
-   [Version support](#version-support)

## About

I created this library to be able to pull it in an existing, non existing, folder opiniated project. The goal is to adapt to bring all the utilities for setting up a routing mecanism in a modular way.

## Requirements

-   PHP version 7.4+
-   Composer installed

## Installation

-   [1. Install the package](1-install-the-package)
-   [2. Bootstrap the router](#2-bootstrap-the-router)

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

-   [1. Register a GET route](#1-register-a-get-route)
-   [2. Register a POST route](#2-register-a-post-route)
-   [3. Catching url not found exceptions](#3-catching-url-not-found-exceptions)
-   [4. Catching method not allowed exceptions](#4-catching-method-not-allowed-exceptions)

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

## Version support

|        | 7.3 | 7.4 | 8.0 |
| ------ | --- | --- | --- |
| v0.1.0 | ❌  | ✔️  | ❓  |