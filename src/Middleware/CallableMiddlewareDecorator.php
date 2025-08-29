<?php declare(strict_types=1);

namespace Borsch\RequestHandler\Middleware;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

class CallableMiddlewareDecorator implements MiddlewareInterface
{

    /** @var callable(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface */
    private $middleware;

    /**
     * @param callable(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface $middleware
     */
    public function __construct(callable $middleware)
    {
        $this->middleware = $middleware;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return call_user_func($this->middleware, $request, $handler);
    }
}
