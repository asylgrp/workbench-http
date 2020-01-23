<?php

declare(strict_types = 1);

namespace spec\workbench\webb\CommandBus;

use workbench\webb\CommandBus\RollbackHandler;
use workbench\webb\CommandBus\Rollback;
use workbench\webb\Event\ChangesDiscarded;
use workbench\webb\Db\TransactionHandlerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RollbackHandlerSpec extends ObjectBehavior
{
    function let(TransactionHandlerInterface $transactionHandler, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($transactionHandler);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RollbackHandler::class);
    }

    function it_dispatches_on_database_rollback($transactionHandler, $dispatcher)
    {
        $transactionHandler->rollback()->willReturn(true)->shouldBeCalled();
        $dispatcher->dispatch(new ChangesDiscarded)->shouldBeCalled();
        $this->handle(new Rollback);
    }

    function it_does_not_dispatch_on_no_rollback($transactionHandler, $dispatcher)
    {
        $transactionHandler->rollback()->willReturn(false)->shouldBeCalled();
        $dispatcher->dispatch(Argument::any())->shouldNotBeCalled();
        $this->handle(new Rollback);
    }
}
