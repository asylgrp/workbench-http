<?php

namespace workbench\webb\Db\Yayson;

use workbench\webb\Db\ContactPersonRepository;
use workbench\webb\Exception\DbConstraintViolationException;
use workbench\webb\Exception\DbEntryDoesNotExistException;
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

    /**
     * @throws DbEntryDoesNotExistException If contact person can not be found
     */
    public function contactPersonFromId(string $id): ContactPersonInterface
    {
        if (!$this->collection->has($id)) {
            throw new DbEntryDoesNotExistException("Unable to find contact person with id $id");
        }

        return $this->normalizer->denormalize($this->collection->read($id), ContactPersonInterface::class);
    }

    public function allContactPersons(): iterable
    {
        foreach ($this->collection as $doc) {
            yield $this->normalizer->denormalize($doc, ContactPersonInterface::class);
        }
    }

    public function createContactPerson(ContactPersonInterface $contactPerson): void
    {
        if ($this->collection->has($contactPerson->getId())) {
            throw new DbConstraintViolationException(
                "Kan ej spara kontaktperson, id {$contactPerson->getId()} finns redan i databas"
            );
        }

        $data = $this->normalizer->normalize($contactPerson);

        $expr = y::atLeastOne(
            y::doc(['account' => y::equals($data['account'] ?? '')]),
            y::doc(['name' => y::equals($data['name'] ?? '')])
        );

        if ($existing = $this->collection->findOne($expr)) {
            throw new DbConstraintViolationException(
                sprintf(
                    "Kan ej spara kontaktperson, kontonummer eller namn finns redan hos %s",
                    $existing['name'] ?? ''
                )
            );
        }

        $this->collection->insert($data, $contactPerson->getId());
    }

    public function deleteContactPerson(ContactPersonInterface $contactPerson): void
    {
        if (!$this->collection->has($contactPerson->getId())) {
            throw new DbEntryDoesNotExistException("Kontaktperson {$contactPerson->getId()} finns inte");
        }

        $this->collection->delete(
            y::doc(['id' => y::equals($contactPerson->getId())])
        );
    }

    public function updateContactPerson(ContactPersonInterface $contactPerson): void
    {
        if (!$this->collection->has($contactPerson->getId())) {
            throw new DbEntryDoesNotExistException("Kontaktperson {$contactPerson->getId()} finns inte");
        }

        $data = $this->normalizer->normalize($contactPerson);

        $expr = y::atLeastOne(
            y::doc([
                'id' => y::not(y::equals($contactPerson->getId())),
                'account' => y::equals($data['account'] ?? ''),
            ]),
            y::doc([
                'id' => y::not(y::equals($contactPerson->getId())),
                'name' => y::equals($data['name'] ?? ''),
            ])
        );

        if ($existing = $this->collection->findOne($expr)) {
            throw new DbConstraintViolationException(
                sprintf(
                    "Kan ej uppdatera kontaktperson, kontonummer eller namn finns redan hos %s",
                    $existing['name'] ?? ''
                )
            );
        }

        $this->collection->insert($data, $contactPerson->getId());
    }
}
