<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Http\Middleware;

use workbench\webb\Http\Middleware\Committer;
use workbench\webb\CommandBus\CommandBus;
use workbench\webb\CommandBus\Commit;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommitterSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->setCommandBus($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Committer::class);
    }

    function it_is_middleware()
    {
        $this->shouldHaveType(MiddlewareInterface::class);
    }

    function it_commits(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
        ResponseInterface $response,
        $commandBus
    ) {
        $handler->handle($request)->willReturn($response);

        $commandBus->handle(new Commit)->shouldBeCalled();

        $this->process($request, $handler)->shouldReturn($response);
    }
}
