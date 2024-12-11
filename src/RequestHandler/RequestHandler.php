<?php

namespace Borsch\RequestHandler;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\{
    ResponseInterface,
    ServerRequestInterface
};
use Psr\Http\Server\MiddlewareInterface;
use RuntimeException;
use SplStack;

class RequestHandler implements RequestHandlerInterface
{

    /**
     * @param SplStack<string>|null $stack
     */
    public function __construct(
        protected ?SplStack $stack = null
    ) {
        $this->stack = $stack ?: new SplStack();
    }

    /**
     * @param MiddlewareInterface $middleware
     * @return $this
     */
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

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->stack->isEmpty()) {
            throw new RuntimeException(
                'The middleware stack is empty and no ResponseInterface has been returned...'
            );
        }

        return $this->stack->shift()->process($request, $this);
    }
}
