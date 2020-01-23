<?php

namespace workbench\webb\Db\Yayson;

use workbench\webb\Db\TransactionHandlerInterface;
use hanneskod\yaysondb\Yaysondb;

final class YaysonTransactionHandler implements TransactionHandlerInterface
{
    private Yaysondb $yaysondb;

    public function __construct(Yaysondb $yaysondb)
    {
        $this->yaysondb = $yaysondb;
    }

    public function commit(): bool
    {
        if ($this->yaysondb->inTransaction()) {
            $this->yaysondb->commit();
            return true;
        }

        return false;
    }

    public function rollback(): bool
    {
        if ($this->yaysondb->inTransaction()) {
            $this->yaysondb->reset();
            return true;
        }

        return false;
    }
}
