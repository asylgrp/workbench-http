<?php

namespace workbench\webb\Storage;

use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;

interface ContactPersonRepositoryInterface
{
    public function createContactPerson(ContactPersonInterface $contactPerson): void;
    public function deleteContactPerson(ContactPersonInterface $contactPerson): void;
    public function updateContactPerson(ContactPersonInterface $contactPerson): void;
}
