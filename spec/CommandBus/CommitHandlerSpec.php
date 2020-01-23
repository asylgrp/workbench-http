<?php

declare(strict_types = 1);

namespace spec\workbench\webb\CommandBus;

use workbench\webb\CommandBus\CommitHandler;
use workbench\webb\CommandBus\Commit;
use workbench\webb\Event\ChangesCommitted;
use workbench\webb\Db\TransactionHandlerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommitHandlerSpec extends ObjectBehavior
{
    function let(TransactionHandlerInterface $transactionHandler, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($transactionHandler);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommitHandler::class);
    }

    function it_dispatches_on_database_commit($transactionHandler, $dispatcher)
    {
        $transactionHandler->commit()->willReturn(true)->shouldBeCalled();
        $dispatcher->dispatch(new ChangesCommitted)->shouldBeCalled();
        $this->handle(new Commit);
    }

    function it_does_not_dispatch_on_no_commit($transactionHandler, $dispatcher)
    {
        $transactionHandler->commit()->willReturn(false)->shouldBeCalled();
        $dispatcher->dispatch(Argument::any())->shouldNotBeCalled();
        $this->handle(new Commit);
    }
}
