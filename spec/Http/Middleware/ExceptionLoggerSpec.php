<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Http\Middleware;

use workbench\webb\Http\Middleware\ExceptionLogger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExceptionLoggerSpec extends ObjectBehavior
{
    function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ExceptionLogger::class);
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

    function it_logs_on_failure(
        $logger,
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) {
        $exception = new \Exception;

        $handler->handle($request)->willThrow($exception);

        $logger->emergency(Argument::type('string'), Argument::type('array'))->shouldBeCalled();

        $this->shouldThrow($exception)->duringProcess($request, $handler);
    }
}
