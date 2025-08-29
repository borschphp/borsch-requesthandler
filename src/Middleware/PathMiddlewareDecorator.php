<?php declare(strict_types=1);

namespace Borsch\RequestHandler\Middleware;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

readonly class PathMiddlewareDecorator implements MiddlewareInterface
{

    public function __construct(
        private string $path,
        private MiddlewareInterface $middleware,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath() ?: '/';
        if (str_starts_with($path, $this->path)) {
            return $this->middleware->process($request, $handler);
        }

        return $handler->handle($request);
    }
}
