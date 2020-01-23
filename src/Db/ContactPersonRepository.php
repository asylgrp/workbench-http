<?php

namespace workbench\webb\Db;

use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use workbench\webb\Exception\DbConstraintViolationException;
use workbench\webb\Exception\DbEntryDoesNotExistException;

interface ContactPersonRepository
{
    /**
     * @return iterable<ContactPersonInterface>
     */
    public function allContactPersons(): iterable;

    /**
     * @throws DbEntryDoesNotExistException If contact person can not be found
     */
    public function contactPersonFromId(string $id): ContactPersonInterface;

    /**
     * @throws DbConstraintViolationException If id, account number or name exists in db
     */
    public function createContactPerson(ContactPersonInterface $contactPerson): void;

    /**
     * @throws DbEntryDoesNotExistException If contact person can not be found
     */
    public function deleteContactPerson(ContactPersonInterface $contactPerson): void;

    /**
     * @throws DbEntryDoesNotExistException If contact person can not be found
     * @throws DbConstraintViolationException If account number or name exists in db
     */
    public function updateContactPerson(ContactPersonInterface $contactPerson): void;
}
