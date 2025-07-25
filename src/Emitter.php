<?php declare(strict_types=1);

namespace Borsch\RequestHandler;

use Psr\Http\Message\{ResponseInterface, StreamInterface};
use function header, sprintf, ucwords;

class Emitter implements EmitterInterface
{

    /**
     * @link https://github.com/http-interop/response-sender/blob/master/src/functions.php
     */
    public function emit(ResponseInterface $response): void
    {
        $this->emitHeaders($response);
        $this->emitStatusLine($response);
        $this->emitBody($response->getBody());
    }

    private function emitHeaders(ResponseInterface $response): void
    {
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf(
                    '%s: %s',
                    ucwords($name, '-'), $value),
                    false
                );
            }
        }
    }

    private function emitStatusLine(ResponseInterface $response): void
    {
        $http_line = sprintf(
            'HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        header($http_line, true, $response->getStatusCode());
    }

    private function emitBody(StreamInterface $stream): void
    {
        if ($stream->isSeekable()) {
            $stream->rewind();
        }

        if (!$stream->isReadable()) {
            echo $stream;
            return;
        }

        $length = 1024 * 8;
        while (!$stream->eof()) {
            echo $stream->read($length);
        }
    }
}
