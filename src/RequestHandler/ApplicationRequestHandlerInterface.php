<?php
/**
 * @author debuss-a
 */

namespace Borsch\RequestHandler;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Interface ApplicationRequestHandlerInterface
 *
 * A simple extension of RequestHandlerInterface to standardize interaction with middlewares.
 *
 * @package Borsch\RequestHandler
 */
interface ApplicationRequestHandlerInterface extends RequestHandlerInterface
{

    /**
     * Add a middleware to the request handler.
     * Must return itself to allow method chaining (if desired).
     *
     * @param MiddlewareInterface $middleware
     * @return ApplicationRequestHandlerInterface
     */
    public function middleware(MiddlewareInterface $middleware): ApplicationRequestHandlerInterface;
}