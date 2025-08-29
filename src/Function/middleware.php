<?php declare(strict_types=1);

namespace Borsch\RequestHandler\Function;

use Borsch\RequestHandler\Middleware\CallableMiddlewareDecorator;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

/**
 * Create a PSR-15 middleware from a callable.
 *
 * @param callable(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface $middleware
 */
function middleware(callable $middleware): MiddlewareInterface
{
    return new CallableMiddlewareDecorator($middleware);
}
