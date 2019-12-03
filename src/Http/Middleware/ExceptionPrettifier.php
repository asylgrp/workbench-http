<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Middlewares\Whoops;

/**
 * Dev exception prettifier that is ignored if whoops is not included in the runtime
 */
final class ExceptionPrettifier implements MiddlewareInterface
{
    private ?Whoops $whoops;

    public function __construct()
    {
        if (class_exists(Whoops::CLASS)) {
            $this->whoops = new Whoops;
        }
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (isset($this->whoops)) {
            return $this->whoops->process($request, $handler);
        }

        return $handler->handle($request);
    }
}
