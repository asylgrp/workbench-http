<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Storage\Yayson;

use workbench\webb\Storage\Yayson\YaysonContactPersonRepository;
use workbench\webb\Storage\ContactPersonRepository;
use workbench\webb\Exception\AccountNumberAlreadyExistException;
use workbench\webb\Exception\ContactPersonAlreadyExistException;
use workbench\webb\Exception\ContactPersonDoesNotExistException;
use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use asylgrp\decisionmaker\Normalizer\ContactPersonNormalizer;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\Collection;
use hanneskod\yaysondb\Engine\FlysystemEngine;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YaysonContactPersonRepositorySpec extends ObjectBehavior
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
        $this->shouldHaveType(YaysonContactPersonRepository::class);
    }

    function it_is_a_contact_person_repository()
    {
        $this->shouldHaveType(ContactPersonRepository::class);
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

    function it_creates(ContactPersonInterface $contact, $normalizer)
    {
        $contact->getId()->willReturn('id');

        $doc = [
            'id' => 'id',
            'account' => 'account',
        ];

        $normalizer->normalize($contact)->willReturn($doc);
        $normalizer->denormalize($doc, ContactPersonInterface::class)->willReturn($contact);

        $this->createContactPerson($contact);

        $this->contactPersons()->shouldIterateAs([$contact]);
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
