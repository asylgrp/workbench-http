<?php

declare(strict_types = 1);

namespace workbench\webb\CommandBus;

use League\Tactician\CommandBus as TacticianCommandBus;

class CommandBus
{
    private TacticianCommandBus $commandBus;

    public function __construct(TacticianCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param object $command
     * @return mixed
     */
    public function handle($command)
    {
        return $this->commandBus->handle($command);
    }
}
