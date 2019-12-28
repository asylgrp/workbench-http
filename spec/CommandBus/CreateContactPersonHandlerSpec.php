<?php

declare(strict_types = 1);

namespace spec\workbench\webb\CommandBus;

use workbench\webb\CommandBus\CreateContactPersonHandler;
use workbench\webb\CommandBus\CreateContactPerson;
use workbench\webb\Event\ContactPersonCreated;
use workbench\webb\Storage\ContactPersonRepository;
use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateContactPersonHandlerSpec extends ObjectBehavior
{
    function let(ContactPersonRepository $contactPersonRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setContactPersonRepository($contactPersonRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateContactPersonHandler::class);
    }

    function it_handles_creations(ContactPersonInterface $contactPerson, $contactPersonRepository, $dispatcher)
    {
        $contactPerson->getId()->willReturn('1');

        $contactPersonRepository->createContactPerson($contactPerson)->shouldBeCalled();
        $dispatcher->dispatch(new ContactPersonCreated($contactPerson->getWrappedObject()))->shouldBeCalled();

        $this->handle(new CreateContactPerson($contactPerson->getWrappedObject()));
    }
}
