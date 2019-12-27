<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Http\Middleware;

use workbench\webb\Http\Middleware\ExceptionEndpoint;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExceptionEndpointSpec extends ObjectBehavior
{
    function let(ResponseFactoryInterface $responseFactory)
    {
        $this->beConstructedWith($responseFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ExceptionEndpoint::class);
    }

    function it_is_middleware()
    {
        $this->shouldHaveType(MiddlewareInterface::class);
    }

    function it_does_nothing_on_success(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
        ResponseInterface $response
    ) {
        $handler->handle($request)->willReturn($response);
        $this->process($request, $handler)->shouldReturn($response);
    }

    function it_returns_server_error_on_failure(
        $responseFactory,
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
        ResponseInterface $response
    ) {
        $handler->handle($request)->willThrow(new \Exception);

        $responseFactory->createResponse(500, 'Internal Server Error')->willReturn($response);

        $this->process($request, $handler)->shouldReturn($response);
    }
}
