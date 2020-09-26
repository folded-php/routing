<?php

declare(strict_types = 1);

namespace Folded;

use Closure;
use Http\Redirection;
use OutOfRangeException;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use InvalidArgumentException;
use FastRoute\RouteParser\Std;
use function Foled\getRequestedUri;
use function FastRoute\simpleDispatcher;
use Folded\Exceptions\UrlNotFoundException;
use Folded\Exceptions\MethodNotAllowedException;
use Folded\Exceptions\RouteNotFoundException;

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
     * @param string  $name   The name of the route (optional).
     *
     * @throws InvalidArgumentException If the route name is empty.
     *
     * @since 0.1.0
     *
     * @example
     * Router::addGetRoute("/", function() {
     *  echo "<h1>Welcome</h1>";
     * });
     */
    public static function addGetRoute(string $route, Closure $action, ?string $name = null): void
    {
        static::addRoute(self::PROTOCOL_GET, $route, $action, $name);
    }

    /**
     * Add a POST route.
     *
     * @param string  $route  The URL or route pattern.
     * @param Closure $action The function to trigger when the current browsed URL matches.
     * @param string  $name   The name of the route (optional).
     *
     * @throws InvalidArgumentException If the route name is empty.
     *
     * @since 0.1.0
     *
     * @example
     * Router::addPostRoute("/search/{search}", function($search) {
     *  echo "search results for $search";
     * });
     */
    public static function addPostRoute(string $route, Closure $action, ?string $name = null): void
    {
        static::addRoute(self::PROTOCOL_POST, $route, $action, $name);
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
     * Returns true if route matches the current URL, else returns false.
     *
     * @param string $route      The route name to verify.
     * @param array  $parameters The parameters to pass to the route if it has named parameters.
     *
     * @throws Folded\Exceptions\RouteNotFoundException If the route name is not found.
     *
     * @since 0.5.0
     *
     * @example
     * if (Router::currentRouteIs("home.index")) {
     *  echo "current route is /";
     * } else {
     *  echo "current route is not /";
     * }
     */
    public static function currentRouteIs(string $route, array $parameters = []): bool
    {
        if (!self::hasRoute($route)) {
            throw (new RouteNotFoundException("route $route not found"))->setRoute($route);
        }

        return self::getRouteUrl($route, $parameters) === $_SERVER["REQUEST_URI"];
    }

    /**
     * Returns true if the URL matches the current URL, else returns false.
     *
     * @param string $url The URL to verify.
     *
     * @throws InvalidArgumentException If the URL is empty.
     *
     * @since 0.5.0
     *
     * @example
     * if (Router::currentUrlIs("/")) {
     *  echo "current URL is /";
     * } else {
     *  echo "current URL is not "/";
     * }
     */
    public static function currentUrlIs(string $url): bool
    {
        if (empty(trim($url))) {
            throw new InvalidArgumentException("url must not be empty");
        }

        return $url === $_SERVER["REQUEST_URI"];
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
     * Get the URL associated with the given route.
     * If the route contains placeholders, you need to pass the parameters to be filled.
     *
     * @param string $name       The name of the route.
     * @param array  $parameters The parameters, by key-value pairs or simply values, to fill in the placeholders (optional).
     *
     * @throws OurOfRangeException If the route name is not found.
     *
     * @since 0.2.0
     *
     * @example
     * Router::getRouteUrl("user.show", ["user" => 42]);
     */
    public static function getRouteUrl(string $name, array $parameters = []): string
    {
        // Use Folded\RouteNotFoundException instead.
        if (!self::hasRoute($name)) {
            throw new OutOfRangeException("route $name not found");
        }

        /**
         * @var Route
         */
        $route = self::$routes[$name];

        return self::replaceRouteParameters($route->getRoute(), $parameters);
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
     * Router::matchRequestedUrl();
     */
    public static function matchRequestedUrl()
    {
        static::startEngine();

        return static::matchUrl();
    }

    /**
     * Redirects to the URL found by its route name.
     *
     * @param string $name   The name of the route.
     * @param array $routeParams Route parameters array
     * @param int $status The HTTP status code to use when redirecting (default: 303 - See other).
     *
     * @throws RouteNotFoundException If the route name is not found.
     *
     * @since 0.3.0
     *
     * @example
     * Router::addGetRoute("/", function() {}, "home.index");
     *
     * Router::redirectToRoute("home.index"); // redirects to "/"
     */
    public static function redirectToRoute(string $name, array $routeParams = [], int $status = Redirection::SEE_OTHER): void
    {
        if (!self::hasRoute($name)) {
            throw (new RouteNotFoundException("route $name not found"))->setRoute($name);
        }

        $url = self::getRouteUrl($name);

        if (!empty($routeParams)) {
            $url = self::appendUrlParams($url, $routeParams);
        }

        http_response_code($status);

        header("Location:$url");
    }

    /**
     * Redirects to a given URL.
     *
     * @param string $url    The URL to redirect to.
     * @param int    $status The HTTP status code ot use when redirecting.
     *
     * @since 0.3.0
     *
     * @example
     * Router::redirectToUrl("/about-us");
     */
    public static function redirectToUrl(string $url, int $status = Redirection::SEE_OTHER): void
    {
        http_response_code($status);

        header("Location:$url");
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
     * @param string  $name     The name of the route (optional).
     *
     * @throws InvalidArgumentException If the route name is empty.
     *
     * @since 0.1.0
     *
     * @example
     * Router::addRoute("GET", "/", fn () => echo "hello world");
     */
    private static function addRoute(string $protocol, string $route, Closure $action, ?string $name = null): void
    {
        $route = new Route($protocol, $route, $action);

        if ($name !== null) {
            if (empty(trim($name))) {
                throw new InvalidArgumentException("route name cannot be empty");
            }

            static::$routes[$name] = $route;
        } else {
            static::$routes[] = $route;
        }
    }

    /**
     * Returns true if the route name is found, else returns false.
     *
     * @param string $name The route name.
     *
     * @since 0.3.0
     *
     * @example
     * if (Router::hasRoute("home.index")) {
     *  echo "has route home.index";
     * } else {
     *  echo "has not route home.index";
     * }
     */
    private static function hasRoute(string $name): bool
    {
        return isset(self::$routes[$name]);
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

    private static function replaceRouteParameters(string $route, array $parameters): string
    {
        $routeDatas = (new Std())->parse($route);
        $placeholders = $parameters;

        $url = "";

        foreach ($routeDatas as $routeData) {
            foreach ($routeData as $data) {
                if (is_string($data)) {
                    // This is a string, so nothing to replace inside of it
                    $url .= $data;
                } elseif (is_array($data)) {
                    // This is an array, so it contains in first the name of the parameter, and in second the regular expression.
                    // Example, [0 => "name", 1 => "[^/]"]
                    [$parameterName, $regularExpression] = $data;

                    $parameterValue = null;

                    if (isset($placeholders[$parameterName])) {
                        // If the parameter name is found by its key in the $parameters parameter, we use it
                        $parameterValue = $placeholders[$parameterName];

                        // We remove it from the remaining placeholders values
                        unset($placeholders[$parameterName]);
                    } elseif (isset($placeholders[0])) {
                        // Else, we take the first parameter in the $parameters parameter
                        $parameterValue = $placeholders[0];

                        // We remove it from the remaining available placeholders values
                        array_shift($placeholders);
                    } else {
                        throw new InvalidArgumentException("parameter $parameterName missing for route $route");
                    }

                    // Checking if the value found matches the regular expression of the associated route parameter
                    $matches = [];
                    $success = preg_match("/" . str_replace("/", "\/", $regularExpression) . "/", (string) $parameterValue, $matches);

                    if ($success !== 1 || (isset($matches[0]) && $parameterValue != $matches[0])) {
                        throw new InvalidArgumentException("parameter $parameterName does not matches regular expression $regularExpression for route $route");
                    }

                    $url .= $parameterValue;
                }
            }
        }

        return $url;
    }

    private static function appendUrlParams(string $url, array $routeParams): string
    {
        foreach ($routeParams as $key => $paramValue) {
            $url = rtrim($url, '/');
            $url .= '/' . $key . '/' . $paramValue;
        }
        return $url;
    }
}
