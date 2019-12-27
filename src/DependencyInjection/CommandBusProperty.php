<?php

declare(strict_types = 1);

namespace workbench\webb\DependencyInjection;

use workbench\webb\CommandBus\CommandBus;

/**
 * Use this trait to automatically inject the command bus
 */
trait CommandBusProperty
{
    protected CommandBus $commandBus;

    /**
     * @required
     */
    public function setCommandBus(CommandBus $commandBus): void
    {
        $this->commandBus = $commandBus;
    }
}
