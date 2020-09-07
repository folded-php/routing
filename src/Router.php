<?php

declare(strict_types = 1);

namespace Folded;

use Closure;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function Foled\getRequestedUri;
use function FastRoute\simpleDispatcher;
use Folded\Exceptions\UrlNotFoundException;
use Folded\Exceptions\MethodNotAllowedException;

/**
 * Represent the engine that matches the current browsed URL against registered URLs.
 *
 * @since 0.1.0
 */
class Router
{
    /**
     * @since 0.1.0
     */
    const ALLOWED_PROTOCOLS = [
        self::PROTOCOL_GET,
        self::PROTOCOL_POST,
    ];

    /**
     * @since 0.1.0
     */
    const PROTOCOL_GET = "GET";

    /**
     * @since 0.1.0
     */
    const PROTOCOL_POST = "POST";

    /**
     * Stores the engine that is responsible for the url matching logic.
     *
     * @var Dispatcher
     */
    private static ?Dispatcher $engine = null;

    /**
     * Stores the registered routes.
     *
     * @since 0.1.0
     */
    private static array $routes = [];

    /**
     * Add a GET route.
     *
     * @param string  $route  The URL or route pattern.
     * @param Closure $action The function to trigger when the current browsed URL matches the route.
     *
     * @since 0.1.0
     *
     * @example
     * Router::addGetRoute("/", function() {
     *  echo "<h1>Welcome</h1>";
     * });
     */
    public static function addGetRoute(string $route, Closure $action): void
    {
        static::addRoute(self::PROTOCOL_GET, $route, $action);
    }

    /**
     * Add a POST route.
     *
     * @since 0.1.0
     *
     * @example
     * Router::addPostRoute("/search/{search}", function($search) {
     *  echo "search results for $search";
     * });
     */
    public static function addPostRoute(string $route, Closure $action): void
    {
        static::addRoute(self::PROTOCOL_POST, $route, $action);
    }

    /**
     * Clears the object, like it has never been called before.
     * Useful for unit testing.
     *
     * @since 0.1.0
     *
     * @example
     * Router::clear();
     */
    public static function clear(): void
    {
        static::$routes = [];
        static::$engine = null;
    }

    /**
     * Get the list of registered routes.
     *
     * @since 0.1.0
     *
     * @example
     * Router::getRoutes();
     */
    public static function getRoutes(): array
    {
        return static::$routes;
    }

    /**
     * Register route and try to match the current browsed URL.
     *
     * @since 0.1.0
     *
     * @throws Folded\Exceptions\UrlNotFoundException      If the URL is not found in the registered routes.
     * @throws Folded\Exceptions\MethodNotAllowedException If the URL has been found, but the current protocol does not match.
     *
     * @example
     * Router::listen();
     */
    public static function matchRequestedUrl()
    {
        static::startEngine();

        return static::matchUrl();
    }

    /**
     * Registers route into the engine.
     *
     * @since 0.1.0
     *
     * @example
     * Router::startEngine();
     */
    public static function startEngine(): void
    {
        self::$engine = simpleDispatcher(static function (RouteCollector $router): void {
            foreach (static::$routes as $route) {
                $router->addRoute($route->getProtocol(), $route->getRoute(), $route->getAction());
            }
        });
    }

    /**
     * Add a route to the list of registered routes.
     *
     * @param string  $protocol The HTTP protocol.
     * @param string  $route    The URL or route pattern.
     * @param Closure $action   The function to trigger when the current browsed URL matches the route.
     *
     * @since 0.1.0
     *
     * @example
     * Router::addRoute("GET", "/", fn () => echo "hello world");
     */
    private static function addRoute(string $protocol, string $route, Closure $action): void
    {
        static::$routes[] = new Route($protocol, $route, $action);
    }

    /**
     * Make the engine to match the current browsed URL.
     *
     * @since 0.1.0
     *
     * @throws Folded\Exceptions\UrlNotFoundException      If the current browsed URL does not match the registered URLs.
     * @throws Folded\Exceptions\MethodNotAllowedException If the current browsed URL matches, but the protocol don't.
     *
     * @example
     * Router::matchUrl();
     */
    private static function matchUrl()
    {
        $requestMethod = getRequestedMethod();
        $uri = getRequestedUri();

        $routeInfo = static::$engine->dispatch($requestMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw (new UrlNotFoundException("url not found"))->setUrl($uri);
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];

                throw (new MethodNotAllowedException("method not allowed"))->setMethodNotAllowed($requestMethod)->setAllowedMethods($allowedMethods);
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                return call_user_func_array($handler, $vars);
        }
    }
}
