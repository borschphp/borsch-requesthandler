<?php declare(strict_types=1);

namespace Borsch\RequestHandler;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\MiddlewareInterface;
use SplStack;
use function get_class, gettype, is_object;

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

        $middleware = $this->stack->shift();
        if (!$middleware instanceof MiddlewareInterface) {
            throw RequestHandlerRuntimeException::invalidMiddleware(
                (string)(is_object($middleware) ? get_class($middleware) : gettype($middleware))
            );
        }

        return $middleware->process($request, $this);
    }
}
