<?php

declare(strict_types = 1);

namespace workbench\webb\Event;

use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use Psr\Log\LogLevel;

class ContactPersonEvent extends LogEvent
{
    private ContactPersonInterface $contactPerson;

    public function __construct(string $message, ContactPersonInterface $contactPerson)
    {
        parent::__construct($message, ['contact_person' => $contactPerson->getId()], LogLevel::INFO);

        $this->contactPerson = $contactPerson;
    }

    public function getContactPerson(): ContactPersonInterface
    {
        return $this->contactPerson;
    }
}
