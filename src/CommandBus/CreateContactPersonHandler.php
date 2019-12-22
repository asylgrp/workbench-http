<?php

declare(strict_types = 1);

namespace workbench\webb\CommandBus;

use workbench\webb\DependencyInjection;
use workbench\webb\Event\ContactPersonCreated;

final class CreateContactPersonHandler
{
    use DependencyInjection\ContactPersonRepositoryProperty,
        DependencyInjection\DispatcherProperty;

    public function handle(CreateContactPerson $command): void
    {
        $this->contactPersonRepository->createContactPerson($command->contactPerson);
        $this->dispatcher->dispatch(new ContactPersonCreated($command->contactPerson));
    }
}
