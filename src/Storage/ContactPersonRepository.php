<?php

namespace workbench\webb\Storage;

use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use workbench\webb\Exception\AccountNumberAlreadyExistException;
use workbench\webb\Exception\ContactPersonAlreadyExistException;
use workbench\webb\Exception\ContactPersonDoesNotExistException;

interface ContactPersonRepository
{
    /**
     * @return iterable<ContactPersonInterface>
     */
    public function allContactPersons(): iterable;

    /**
     * @throws ContactPersonDoesNotExistException If contact person can not be found
     */
    public function contactPersonFromId(string $id): ContactPersonInterface;

    /**
     * @throws ContactPersonAlreadyExistException If contact person id exists in db
     * @throws AccountNumberAlreadyExistException If account number exists in db
     */
    public function createContactPerson(ContactPersonInterface $contactPerson): void;

    /**
     * @throws ContactPersonDoesNotExistException If contact person can not be found
     */
    public function deleteContactPerson(ContactPersonInterface $contactPerson): void;

    /**
     * @throws ContactPersonDoesNotExistException If contact person can not be found
     * @throws AccountNumberAlreadyExistException If account number exists in db
     */
    public function updateContactPerson(ContactPersonInterface $contactPerson): void;
}
