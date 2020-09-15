# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.3.0] 2020-09-15

### Added

- New method `redirectToRoute("home.index")` which redirect to the URL matching the route name.
- New method `redirectToUrl("/about-us")` which redirects to a plain URL.

## [0.2.0] 2020-09-12

### Added

- New third optional parameter `$name` for the methods `addGetRoute()` and `addPostRoute()` to name a route.
- New method `getRouteUrl("home.index")` to get the URL from a route name.

## [0.1.3] 2020-09-07

### Added

- **Nothing change** on your code. We moved from local exception to shared exception internally for both `Folded\Exceptions\UrlNotFoundException` and `Folded\Exception\MethodNotAllowedException`.

## [0.1.2] 2020-09-05

### Fixed

- Bug when `addGetRoute()` and `addPostRoute()` were not found.

## [0.1.1] 2020-09-05

### Fixed

- On an IDE that auto import namespaces, exceptions will now be imported prefixed with Folded namespace (instead of another one).

## [0.1.0] 2020-09-05

### Added

- First working version.
