<?php

namespace Borsch\RequestHandler\Exception;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class RequestHandlerRuntimeException extends RuntimeException
{

    public static function emptyStack(): self
    {
        return new self(sprintf(
            'The middleware stack is empty and no %s has been returned',
            ResponseInterface::class
        ));
    }
}