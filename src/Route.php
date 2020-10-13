<?php

declare(strict_types = 1);

namespace Folded;

use Closure;
use InvalidArgumentException;

/**
 * Represents an HTTP route.
 *
 * @since 0.1.0
 */
final class Route
{
    /**
     * The function to call when the route matches the current browsed URL.
     *
     * @since 0.1.0
     */
    private Closure $action;

    /**
     * The HTTP protocol.
     *
     * @since 0.1.0
     */
    private string $protocol;

    /**
     * The URL or route pattern.
     *
     * @since 0.1.0
     */
    private string $route;

    /**
     * Constructor.
     *
     * @param string  $protocol The HTTP protocol.
     * @param string  $route    The URL or route pattern.
     * @param Closure $action   The function to trigger when the route matches the current browsed URL.
     *
     * @throws InvalidArgumentException If the protocol is not valid.
     * @throws InvalidArgumentException If the route is not valid.
     *
     * @since 0.1.0
     *
     * @example
     * $route = new Route("GET", "/", fn () => echo "hello world");
     */
    public function __construct(string $protocol, string $route, Closure $action)
    {
        self::checkProtocol($protocol);
        self::checkRoute($route);

        $this->protocol = $protocol;
        $this->route = $route;
        $this->action = $action;
    }

    /**
     * Returns the action.
     *
     * @since 0.1.0
     *
     * @example
     * $route = new Route("GET", "/", fn () => echo "hello world");
     *
     * $route->getAction();
     */
    public function getAction(): Closure
    {
        return $this->action;
    }

    /**
     * Returns the HTTP protocol.
     *
     * @since 0.1.0
     *
     * @example
     * $route = new Route("GET", "/", fn () => echo "hello world");
     *
     * $route->getProtocol();
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * Returns the route.
     *
     * @since 0.1.0
     *
     * @example
     * $route = new Route("GET", "/", fn () => echo "hello world");
     *
     * $route->getRoute();
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * Returns true if the route is valid, else returns false.
     *
     * @param string $route The URL or route pattern.
     *
     * @since 0.1.0
     *
     * @example
     * if (Route::isValid("/")) {
     *  echo "Route / is valid.";
     * } else {
     *  echo "Route / is not valid.";
     * }
     */
    public static function isValid(string $route): bool
    {
        return !empty(trim($route));
    }

    /**
     * Raises an exception if the protocol is not valid.
     *
     * @param string $protocol The HTTP protocol.
     *
     * @throws InvalidArgumentException If the protocol is not valid.
     *
     * @since 0.1.0
     *
     * @example
     * Route::checkProtocol("GET");
     */
    private static function checkProtocol(string $protocol): void
    {
        if (!RequestMethod::isValid($protocol)) {
            throw new InvalidArgumentException("protocol $protocol is not valid");
        }
    }

    /**
     * Raises an exception if the route is not valid.
     *
     * @param string $route The URL or route pattern.
     *
     * @throws InvalidArgumentException If the route is empty.
     *
     * @since 0.1.0
     *
     * @example
     * Route::checkRoute("/");
     */
    private static function checkRoute(string $route): void
    {
        if (!self::isValid($route)) {
            throw new InvalidArgumentException("route is empty");
        }
    }
}
