<?php

namespace workbench\webb\Storage\Yayson;

use workbench\webb\Storage\ContactPersonRepository;
use workbench\webb\Exception\AccountNumberAlreadyExistException;
use workbench\webb\Exception\ContactPersonAlreadyExistException;
use workbench\webb\Exception\ContactPersonDoesNotExistException;
use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use asylgrp\decisionmaker\Normalizer\ContactPersonNormalizer;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\Operators as y;

final class YaysonContactPersonRepository implements ContactPersonRepository
{
    /** @var CollectionInterface<array> */
    private CollectionInterface $collection;
    private ContactPersonNormalizer $normalizer;

    /**
     * @param CollectionInterface<array> $collection
     */
    public function __construct(CollectionInterface $collection, ContactPersonNormalizer $normalizer)
    {
        $this->collection = $collection;
        $this->normalizer = $normalizer;
    }

    // TODO spec för dessa tre...
    public function activeContactPersons(): iterable
    {
        yield from $this->findContactPersons(ContactPersonNormalizer::STATUS_ACTIVE);
    }

    public function bannedContactPersons(): iterable
    {
        yield from $this->findContactPersons(ContactPersonNormalizer::STATUS_BANNED);
    }

    public function blockedContactPersons(): iterable
    {
        yield from $this->findContactPersons(ContactPersonNormalizer::STATUS_BLOCKED);
    }

    public function createContactPerson(ContactPersonInterface $contactPerson): void
    {
        if ($this->collection->has($contactPerson->getId())) {
            throw new ContactPersonAlreadyExistException(
                "Kan ej spara kontaktperson, id {$contactPerson->getId()} finns redan i databas"
            );
        }

        $data = $this->normalizer->normalize($contactPerson);

        $expr = y::doc(['account' => y::equals($data['account'] ?? '')]);

        if ($existing = $this->collection->findOne($expr)) {
            throw new AccountNumberAlreadyExistException(
                sprintf(
                    "Kan ej spara kontaktperson, kontonummer %s finns redan hos %s",
                    $existing['account'] ?? '',
                    $existing['name'] ?? ''
                )
            );
        }

        $this->collection->insert($data, $contactPerson->getId());
    }

    public function deleteContactPerson(ContactPersonInterface $contactPerson): void
    {
        if (!$this->collection->has($contactPerson->getId())) {
            throw new ContactPersonDoesNotExistException("Kontaktperson {$contactPerson->getId()} finns inte");
        }

        $this->collection->delete(
            y::doc(['id' => y::equals($contactPerson->getId())])
        );
    }

    public function updateContactPerson(ContactPersonInterface $contactPerson): void
    {
        if (!$this->collection->has($contactPerson->getId())) {
            throw new ContactPersonDoesNotExistException("Kontaktperson {$contactPerson->getId()} finns inte");
        }

        $data = $this->normalizer->normalize($contactPerson);

        $expr = y::doc([
            'id' => y::not(y::equals($contactPerson->getId())),
            'account' => y::equals($data['account'] ?? ''),
        ]);

        if ($existing = $this->collection->findOne($expr)) {
            throw new AccountNumberAlreadyExistException(
                sprintf(
                    "Kan ej uppdatera kontaktperson, kontonummer %s finns redan hos %s",
                    $existing['account'] ?? '',
                    $existing['name'] ?? ''
                )
            );
        }

        $this->collection->insert($data, $contactPerson->getId());
    }

    /**
     * @return iterable<ContactPersonInterface>
     */
    private function findContactPersons(string $status): iterable
    {
        $expr = y::doc(['status' => y::equals($status)]);

        foreach ($this->collection->find($expr) as $doc) {
            yield $this->normalizer->denormalize($doc, ContactPersonInterface::class);
        }
    }
}
