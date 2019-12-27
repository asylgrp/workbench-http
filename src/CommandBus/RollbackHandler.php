<?php

declare(strict_types = 1);

namespace workbench\webb\CommandBus;

use workbench\webb\DependencyInjection\DispatcherProperty;
use workbench\webb\Event\ChangesDiscarded;
use workbench\webb\Storage\TransactionHandlerInterface;

final class RollbackHandler
{
    use DispatcherProperty;

    private TransactionHandlerInterface $transactionHandler;

    public function __construct(TransactionHandlerInterface $transactionHandler)
    {
        $this->transactionHandler = $transactionHandler;
    }

    public function handle(Rollback $rollback): void
    {
        if ($this->transactionHandler->rollback()) {
            $this->dispatcher->dispatch(new ChangesDiscarded);
        }
    }
}
