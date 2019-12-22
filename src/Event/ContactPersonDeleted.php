<?php

declare(strict_types = 1);

namespace workbench\webb\Event;

use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;

class ContactPersonDeleted extends ContactPersonEvent
{
    public function __construct(ContactPersonInterface $contactPerson)
    {
        parent::__construct("Deleted contact person '{$contactPerson->getId()}'", $contactPerson);
    }
}
