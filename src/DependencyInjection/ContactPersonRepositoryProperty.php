<?php

declare(strict_types = 1);

namespace workbench\webb\DependencyInjection;

use workbench\webb\Db\ContactPersonRepository;

/**
 * Use this trait to automatically inject a contact person repository object
 */
trait ContactPersonRepositoryProperty
{
    protected ContactPersonRepository $contactPersonRepository;

    /**
     * @required
     */
    public function setContactPersonRepository(ContactPersonRepository $contactPersonRepository): void
    {
        $this->contactPersonRepository = $contactPersonRepository;
    }
}
