<?php

declare(strict_types = 1);

namespace workbench\webb\CommandBus;

use workbench\webb\DependencyInjection;
use workbench\webb\Event\ContactPersonUpdated;

final class UpdateContactPersonHandler
{
    use DependencyInjection\ContactPersonRepositoryProperty,
        DependencyInjection\DispatcherProperty;

    public function handle(UpdateContactPerson $command): void
    {
        $this->contactPersonRepository->updateContactPerson($command->contactPerson);
        $this->dispatcher->dispatch(new ContactPersonUpdated($command->contactPerson));
    }
}
