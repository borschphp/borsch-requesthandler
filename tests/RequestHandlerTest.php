<?php

namespace BorschTest;

require_once __DIR__.'/../vendor/autoload.php';

use Borsch\RequestHandler\RequestHandler;
use BorschTest\Mockup\FirstMiddleware;
use BorschTest\Mockup\HeaderMiddleware;
use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class RequestHandlerTest extends TestCase
{

    protected RequestHandler $handler;

    public function setUp(): void
    {
        $this->handler = new RequestHandler();
    }

    public function testMiddleware()
    {
        $this->handler->middleware(new FirstMiddleware());
        $response = $this->handler->handle(ServerRequestFactory::fromGlobals());

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(FirstMiddleware::class.'::process', $response->getBody()->getContents());
    }

    public function testMiddlewares()
    {
        $this->handler->middlewares([
            new HeaderMiddleware(),
            new FirstMiddleware()
        ]);
        $response = $this->handler->handle(ServerRequestFactory::fromGlobals());

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(FirstMiddleware::class.'::process', $response->getBody()->getContents());
        $this->assertEquals(HeaderMiddleware::class.'::process', $response->getHeaderLine('X-Tests'));
    }

    public function testHandle()
    {
        $this->handler->middlewares([
            new HeaderMiddleware(),
            new FirstMiddleware()
        ]);
        $response = $this->handler->handle(ServerRequestFactory::fromGlobals());

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testHandleWithoutMiddlewareResultsInException()
    {
        $this->expectException(\RuntimeException::class);
        $this->handler->handle(ServerRequestFactory::fromGlobals());
    }
}
