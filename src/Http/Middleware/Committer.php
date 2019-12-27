<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Middleware;

use workbench\webb\DependencyInjection\CommandBusProperty;
use workbench\webb\CommandBus\Commit;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Committer implements MiddlewareInterface
{
    use CommandBusProperty;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        $this->commandBus->handle(new Commit);

        return $response;
    }
}
