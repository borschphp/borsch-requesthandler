<?php declare(strict_types=1);

namespace Borsch\RequestHandler;

use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface as PsrRequestHandlerInterface};

/**
 * A simple extension of RequestHandlerInterface to standardize interaction with middlewares.
 */
interface RequestHandlerInterface extends PsrRequestHandlerInterface
{

    /**
     * Add middleware to the request handler.
     * Must return itself to allow method chaining (if desired).
     */
    public function middleware(MiddlewareInterface $middleware): RequestHandlerInterface;
}
