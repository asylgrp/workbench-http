<?php

declare(strict_types = 1);

namespace workbench\webb\CommandBus;

use workbench\webb\DependencyInjection\DispatcherProperty;
use workbench\webb\Event\ChangesCommitted;
use workbench\webb\Db\TransactionHandlerInterface;

final class CommitHandler
{
    use DispatcherProperty;

    private TransactionHandlerInterface $transactionHandler;

    public function __construct(TransactionHandlerInterface $transactionHandler)
    {
        $this->transactionHandler = $transactionHandler;
    }

    public function handle(Commit $commit): void
    {
        if ($this->transactionHandler->commit()) {
            $this->dispatcher->dispatch(new ChangesCommitted);
        }
    }
}
