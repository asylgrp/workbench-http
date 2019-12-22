<?php

declare(strict_types = 1);

namespace workbench\webb\CommandBus;

use workbench\webb\DependencyInjection;
use workbench\webb\Event\ContactPersonDeleted;

final class DeleteContactPersonHandler
{
    use DependencyInjection\ContactPersonRepositoryProperty,
        DependencyInjection\DispatcherProperty;

    public function handle(DeleteContactPerson $command): void
    {
        $this->contactPersonRepository->deleteContactPerson($command->contactPerson);
        $this->dispatcher->dispatch(new ContactPersonDeleted($command->contactPerson));
    }
}
