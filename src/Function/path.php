<?php declare(strict_types=1);

namespace Borsch\RequestHandler\Function;

use Borsch\RequestHandler\Middleware\PathMiddlewareDecorator;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Create a PSR-15 middleware from a base path.
 */
function path(string $path, MiddlewareInterface $middleware): MiddlewareInterface
{
    return new PathMiddlewareDecorator($path, $middleware);
}
