<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Storage\Json;

use workbench\webb\Storage\Json\JsonContactPersonRepository;
use workbench\webb\Storage\ContactPersonRepositoryInterface;
use workbench\webb\Exception\AccountNumberAlreadyExistException;
use workbench\webb\Exception\ContactPersonAlreadyExistException;
use workbench\webb\Exception\ContactPersonDoesNotExistException;
use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use asylgrp\decisionmaker\Normalizer\ContactPersonNormalizer;
use hanneskod\yaysondb\CollectionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use hanneskod\yaysondb\Collection;
use hanneskod\yaysondb\Engine\FlysystemEngine;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

class JsonContactPersonRepositorySpec extends ObjectBehavior
{
    private CollectionInterface $collection;

    function let(ContactPersonNormalizer $normalizer)
    {
        $fs = new Filesystem(new MemoryAdapter);
        $fs->write('foo', '');

        $this->collection = new Collection(new FlysystemEngine('foo', $fs));

        $this->beConstructedWith($this->collection, $normalizer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(JsonContactPersonRepository::class);
    }

    function it_is_a_contact_person_repository()
    {
        $this->shouldHaveType(ContactPersonRepositoryInterface::class);
    }

    function it_throws_on_creation_if_id_exists(ContactPersonInterface $contact, $normalizer)
    {
        $contact->getId()->willReturn('id');

        $normalizer->normalize($contact)->willReturn([
            'id' => 'id',
            'account' => 'account',
        ]);

        $this->createContactPerson($contact);

        $this->shouldThrow(ContactPersonAlreadyExistException::class)->duringCreateContactPerson($contact);
    }

    function it_throws_on_creation_if_account_exists(
        ContactPersonInterface $foo,
        ContactPersonInterface $bar,
        $normalizer
    ) {
        $foo->getId()->willReturn('foo');
        $bar->getId()->willReturn('bar');

        $normalizer->normalize($foo)->willReturn([
            'id' => 'foo',
            'account' => 'account',
        ]);

        $normalizer->normalize($bar)->willReturn([
            'id' => 'bar',
            'account' => 'account',
        ]);

        $this->createContactPerson($foo);

        $this->shouldThrow(AccountNumberAlreadyExistException::class)->duringCreateContactPerson($bar);
    }

    function it_throws_on_delete_unknown(ContactPersonInterface $contact)
    {
        $contact->getId()->willReturn('does-not-exist');
        $this->shouldThrow(ContactPersonDoesNotExistException::class)->duringDeleteContactPerson($contact);
    }

    function it_throws_on_update_unknown(ContactPersonInterface $contact)
    {
        $contact->getId()->willReturn('does-not-exist');
        $this->shouldThrow(ContactPersonDoesNotExistException::class)->duringUpdateContactPerson($contact);
    }

    function it_deletes(ContactPersonInterface $contact, $normalizer)
    {
        $contact->getId()->willReturn('id');

        $normalizer->normalize($contact)->willReturn([
            'id' => 'id',
            'account' => 'account',
        ]);

        $this->createContactPerson($contact);

        $this->deleteContactPerson($contact);

        $this->shouldThrow(ContactPersonDoesNotExistException::class)->duringUpdateContactPerson($contact);
    }

    function it_throws_on_update_if_account_exists(
        ContactPersonInterface $foo,
        ContactPersonInterface $bar,
        ContactPersonInterface $bar2foo,
        $normalizer
    ) {
        $foo->getId()->willReturn('foo');
        $bar->getId()->willReturn('bar');
        $bar2foo->getId()->willReturn('bar');

        $normalizer->normalize($foo)->willReturn([
            'id' => 'foo',
            'account' => 'foo',
        ]);

        $normalizer->normalize($bar)->willReturn([
            'id' => 'bar',
            'account' => 'bar',
        ]);

        $normalizer->normalize($bar2foo)->willReturn([
            'id' => 'bar',
            'account' => 'foo',
        ]);

        $this->createContactPerson($foo);
        $this->createContactPerson($bar);

        $this->shouldThrow(AccountNumberAlreadyExistException::class)->duringUpdateContactPerson($bar2foo);
    }

    function it_updates(
        ContactPersonInterface $bar,
        ContactPersonInterface $bar2foo,
        ContactPersonInterface $foo,
        $normalizer
    ) {
        $bar->getId()->willReturn('bar');
        $bar2foo->getId()->willReturn('bar');
        $foo->getId()->willReturn('foo');

        $normalizer->normalize($bar)->willReturn([
            'id' => 'bar',
            'account' => 'bar',
        ]);

        $normalizer->normalize($bar2foo)->willReturn([
            'id' => 'bar',
            'account' => 'foo',
        ]);

        $normalizer->normalize($foo)->willReturn([
            'id' => 'foo',
            'account' => 'foo',
        ]);

        $this->createContactPerson($bar);

        $this->updateContactPerson($bar2foo);

        $this->shouldThrow(AccountNumberAlreadyExistException::class)->duringCreateContactPerson($foo);
    }
}
