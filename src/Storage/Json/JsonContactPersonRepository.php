<?php

namespace workbench\webb\Storage\Json;

use workbench\webb\Storage\ContactPersonRepositoryInterface;
use workbench\webb\Exception\AccountNumberAlreadyExistException;
use workbench\webb\Exception\ContactPersonAlreadyExistException;
use workbench\webb\Exception\ContactPersonDoesNotExistException;
use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use asylgrp\decisionmaker\Normalizer\ContactPersonNormalizer;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\Operators as y;

final class JsonContactPersonRepository implements ContactPersonRepositoryInterface
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

    public function createContactPerson(ContactPersonInterface $contactPerson): void
    {
        if ($this->collection->has($contactPerson->getId())) {
            throw new ContactPersonAlreadyExistException(
                "Unable to save contact person {$contactPerson->getId()}, id already exists"
            );
        }

        $data = $this->normalizer->normalize($contactPerson);

        $expr = y::doc(['account' => y::equals($data['account'] ?? '')]);

        if ($existing = $this->collection->findOne($expr)) {
            throw new AccountNumberAlreadyExistException(
                sprintf(
                    "Unable to save contact person %s, account nummber %s already exists in %s",
                    $contactPerson->getId(),
                    $existing['account'] ?? '',
                    $existing['id'] ?? ''
                )
            );
        }

        $this->collection->insert($data, $contactPerson->getId());
    }

    public function deleteContactPerson(ContactPersonInterface $contactPerson): void
    {
        if (!$this->collection->has($contactPerson->getId())) {
            throw new ContactPersonDoesNotExistException("Unknown contact person: {$contactPerson->getId()}");
        }

        $this->collection->delete(
            y::doc(['id' => y::equals($contactPerson->getId())])
        );
    }

    public function updateContactPerson(ContactPersonInterface $contactPerson): void
    {
        if (!$this->collection->has($contactPerson->getId())) {
            throw new ContactPersonDoesNotExistException("Unknown contact person: {$contactPerson->getId()}");
        }

        $data = $this->normalizer->normalize($contactPerson);

        $expr = y::doc([
            'id' => y::not(y::equals($contactPerson->getId())),
            'account' => y::equals($data['account'] ?? ''),
        ]);

        if ($existing = $this->collection->findOne($expr)) {
            throw new AccountNumberAlreadyExistException(
                sprintf(
                    "Unable to update contact person %s, account nummber %s already exists in %s",
                    $contactPerson->getId(),
                    $existing['account'] ?? '',
                    $existing['id'] ?? ''
                )
            );
        }

        $this->collection->insert($data, $contactPerson->getId());
    }
}
