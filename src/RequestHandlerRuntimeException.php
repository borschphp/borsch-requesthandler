<?php declare(strict_types=1);

namespace Borsch\RequestHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use RuntimeException;
use function sprintf;

class RequestHandlerRuntimeException extends RuntimeException
{

    public static function emptyStack(): self
    {
        return new self(sprintf(
            'The middleware stack is empty and no %s has been returned',
            ResponseInterface::class
        ));
    }

    public static function invalidMiddleware(string $middleware): self
    {
        return new self(sprintf(
            'The middleware "%s" must implement %s',
            $middleware,
            MiddlewareInterface::class
        ));
    }
}
