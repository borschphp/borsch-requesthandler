<?php declare(strict_types=1);

namespace Borsch\RequestHandler;

interface RequestHandlerRunnerInterface
{

    /**
     * Run the request handler.
     * This method should handle the request and send the response.
     */
    public function run(): void;
}
