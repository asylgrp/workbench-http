<?php

declare(strict_types = 1);

namespace workbench\webb\DependencyInjection;

use workbench\webb\Storage\ContactPersonRepositoryInterface;

/**
 * Use this trait to automatically inject a contact person repository object
 */
trait ContactPersonRepositoryProperty
{
    protected ContactPersonRepositoryInterface $contactPersonRepository;

    /**
     * @required
     */
    public function setContactPersonRepository(ContactPersonRepositoryInterface $contactPersonRepository): void
    {
        $this->contactPersonRepository = $contactPersonRepository;
    }
}
