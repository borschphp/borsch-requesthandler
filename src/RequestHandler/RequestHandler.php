<?php
/**
 * @author debuss-a
 */

namespace Borsch\RequestHandler;

use Psr\Http\Message\{
    ResponseInterface,
    ServerRequestInterface
};
use Psr\Http\Server\MiddlewareInterface;
use RuntimeException;
use SplStack;

/**
 * Class App
 * @package Borsch\RequestHandler
 */
class RequestHandler implements ApplicationRequestHandlerInterface
{

    /**
     * App constructor.
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
    public function middleware(MiddlewareInterface $middleware): ApplicationRequestHandlerInterface
    {
        $this->stack->push($middleware);

        return $this;
    }

    /**
     * @param array $middlewares
     * @return $this
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
