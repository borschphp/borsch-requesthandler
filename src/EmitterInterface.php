<?php declare(strict_types=1);

namespace Borsch\RequestHandler;

use Psr\Http\Message\ResponseInterface;

interface EmitterInterface
{

    /**
     * Emits the given response.
     *
     * @param ResponseInterface $response The response to emit.
     */
    public function emit(ResponseInterface $response): void;
}
