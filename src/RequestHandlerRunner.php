<?php declare(strict_types=1);

namespace Borsch\RequestHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final class RequestHandlerRunner implements RequestHandlerRunnerInterface
{

    /** @var callable(): ServerRequestInterface */
    private $server_request_factory;

    /** @var callable(Throwable $e): ResponseInterface */
    private $error_response_factory;

    /**
     * @param callable(): ServerRequestInterface $server_request_factory
     * @param callable(Throwable $e): ResponseInterface $error_response_factory
     */
    public function __construct(
        private readonly RequestHandlerInterface $handler,
        private readonly EmitterInterface $emitter,
        callable $server_request_factory,
        callable $error_response_factory,
    ) {
        $this->server_request_factory = $server_request_factory;
        $this->error_response_factory = $error_response_factory;
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        try {
            $request = ($this->server_request_factory)();
        } catch (Throwable $e) {
            $this->emitter->emit(
                ($this->error_response_factory)($e)
            );

            return;
        }

        $this->emitter->emit(
            $this->handler->handle($request)
        );
    }
}
