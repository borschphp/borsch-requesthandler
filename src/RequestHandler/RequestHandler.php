<?php

namespace Borsch\RequestHandler;

use Borsch\RequestHandler\Exception\RequestHandlerRuntimeException;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\MiddlewareInterface;
use SplStack;

class RequestHandler implements RequestHandlerInterface
{

    /**
     * @param SplStack<MiddlewareInterface>|null $stack
     */
    public function __construct(
        protected ?SplStack $stack = null
    ) {
        $this->stack = $stack ?: new SplStack();
    }

    public function middleware(MiddlewareInterface $middleware): self
    {
        $this->stack->push($middleware);

        return $this;
    }

    /**
     * @param MiddlewareInterface[] $middlewares
     */
    public function middlewares(array $middlewares): self
    {
        foreach ($middlewares as $middleware) {
            $this->middleware($middleware);
        }

        return $this;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->stack->isEmpty()) {
            throw RequestHandlerRuntimeException::emptyStack();
        }

        return $this->stack->shift()->process($request, $this);
    }
}
