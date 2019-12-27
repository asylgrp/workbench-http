<?php

declare(strict_types = 1);

namespace spec\workbench\webb\CommandBus;

use workbench\webb\CommandBus\LoggingMiddleware;
use workbench\webb\Event\LogEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoggingMiddlewareSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LoggingMiddleware::class);
    }

    function it_loggs_command($dispatcher)
    {
        $command = new class {
            public $data = 'foobar';
        };

        $next = function ($command) {
            return $command->data;
        };

        $dispatcher->dispatch(Argument::type(LogEvent::class))->shouldBeCalled();

        $this->execute($command, $next)->shouldReturn('foobar');
    }
}
