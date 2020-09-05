<?php

declare(strict_types = 1);

namespace Folded;

/**
 * Represents HTTP request methods.
 *
 * @since 0.1.0
 */
class RequestMethod
{
    /**
     * @since 0.1.0
     */
    const ALLOWED = [
        self::GET,
        self::POST,
    ];

    /**
     * @since 0.1.0
     */
    const GET = "GET";

    /**
     * @since 0.1.0
     */
    const POST = "POST";

    /**
     * Returns true if the protocol is allowed, else returns false.
     *
     * @param string $protocol The HTTP protocol to check.
     *
     * @since 0.1.0
     *
     * @example
     * if (RequestMethod::isValid("GET")) {
     *  echo "GET is a valid HTTP protocol.";
     * } else {
     *  echo "GET is not a valid HTTP protocol.";
     * }
     */
    public static function isValid(string $protocol): bool
    {
        return in_array(mb_strtoupper($protocol), self::ALLOWED, true);
    }
}
