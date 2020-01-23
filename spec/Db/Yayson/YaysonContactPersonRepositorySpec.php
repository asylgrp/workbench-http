<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Db\Yayson;

use workbench\webb\Db\Yayson\YaysonContactPersonRepository;
use workbench\webb\Db\ContactPersonRepository;
use workbench\webb\Exception\DbConstraintViolationException;
use workbench\webb\Exception\DbEntryDoesNotExistException;
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

        $this->shouldThrow(DbConstraintViolationException::class)->duringCreateContactPerson($contact);
    }

    function it_throws_on_creation_if_name_exists(
        ContactPersonInterface $foo,
        ContactPersonInterface $bar,
        $normalizer
    ) {
        $foo->getId()->willReturn('foo');
        $bar->getId()->willReturn('bar');

        $normalizer->normalize($foo)->willReturn([
            'id' => 'foo',
            'account' => 'foo',
            'name' => 'name'
        ]);

        $normalizer->normalize($bar)->willReturn([
            'id' => 'bar',
            'account' => 'bar',
            'name' => 'name'
        ]);

        $this->createContactPerson($foo);

        $this->shouldThrow(DbConstraintViolationException::class)->duringCreateContactPerson($bar);
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
            'name' => 'foo'
        ]);

        $normalizer->normalize($bar)->willReturn([
            'id' => 'bar',
            'account' => 'account',
            'name' => 'bar'
        ]);

        $this->createContactPerson($foo);

        $this->shouldThrow(DbConstraintViolationException::class)->duringCreateContactPerson($bar);
    }

    function it_creates(ContactPersonInterface $contact, $normalizer)
    {
        $contact->getId()->willReturn('id');

        $doc = [
            'id' => 'id',
            'account' => 'account',
            'name' => 'name'
        ];

        $normalizer->normalize($contact)->willReturn($doc);
        $normalizer->denormalize($doc, ContactPersonInterface::class)->willReturn($contact);

        $this->createContactPerson($contact);

        $this->allContactPersons()->shouldIterateAs([$contact]);
    }

    function it_throw_if_contact_person_does_not_exist()
    {
        $this->shouldThrow(DbEntryDoesNotExistException::class)->duringContactPersonFromId('does-not-exist');
    }

    function it_can_fetch_contact_person(ContactPersonInterface $contact, $normalizer)
    {
        $contact->getId()->willReturn('id');

        $doc = [
            'id' => 'id',
            'account' => 'account',
            'name' => 'name'
        ];

        $normalizer->normalize($contact)->willReturn($doc);
        $normalizer->denormalize($doc, ContactPersonInterface::class)->willReturn($contact);

        $this->createContactPerson($contact);

        $this->contactPersonFromId('id')->shouldReturn($contact);
    }

    function it_throws_on_delete_unknown(ContactPersonInterface $contact)
    {
        $contact->getId()->willReturn('does-not-exist');
        $this->shouldThrow(DbEntryDoesNotExistException::class)->duringDeleteContactPerson($contact);
    }

    function it_throws_on_update_unknown(ContactPersonInterface $contact)
    {
        $contact->getId()->willReturn('does-not-exist');
        $this->shouldThrow(DbEntryDoesNotExistException::class)->duringUpdateContactPerson($contact);
    }

    function it_deletes(ContactPersonInterface $contact, $normalizer)
    {
        $contact->getId()->willReturn('id');

        $normalizer->normalize($contact)->willReturn([
            'id' => 'id',
            'account' => 'account',
            'name' => 'name'
        ]);

        $this->createContactPerson($contact);

        $this->deleteContactPerson($contact);

        $this->shouldThrow(DbEntryDoesNotExistException::class)->duringUpdateContactPerson($contact);
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
            'name' => 'foo'
        ]);

        $normalizer->normalize($bar)->willReturn([
            'id' => 'bar',
            'account' => 'bar',
            'name' => 'bar'
        ]);

        $normalizer->normalize($bar2foo)->willReturn([
            'id' => 'bar',
            'account' => 'foo',
            'name' => 'bar'
        ]);

        $this->createContactPerson($foo);
        $this->createContactPerson($bar);

        $this->shouldThrow(DbConstraintViolationException::class)->duringUpdateContactPerson($bar2foo);
    }

    function it_throws_on_update_if_name_exists(
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
            'name' => 'foo'
        ]);

        $normalizer->normalize($bar)->willReturn([
            'id' => 'bar',
            'account' => 'bar',
            'name' => 'bar'
        ]);

        $normalizer->normalize($bar2foo)->willReturn([
            'id' => 'bar',
            'account' => 'bar',
            'name' => 'foo'
        ]);

        $this->createContactPerson($foo);
        $this->createContactPerson($bar);

        $this->shouldThrow(DbConstraintViolationException::class)->duringUpdateContactPerson($bar2foo);
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
            'name' => 'bar'
        ]);

        $normalizer->normalize($bar2foo)->willReturn([
            'id' => 'bar',
            'account' => 'foo',
            'name' => 'foo'
        ]);

        $normalizer->normalize($foo)->willReturn([
            'id' => 'foo',
            'account' => 'foo',
            'name' => 'foo'
        ]);

        $this->createContactPerson($bar);

        $this->updateContactPerson($bar2foo);

        $this->shouldThrow(DbConstraintViolationException::class)->duringCreateContactPerson($foo);
    }
}
