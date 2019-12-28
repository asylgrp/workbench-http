<?php

declare(strict_types = 1);

namespace spec\workbench\webb\CommandBus;

use workbench\webb\CommandBus\UpdateContactPersonHandler;
use workbench\webb\CommandBus\UpdateContactPerson;
use workbench\webb\Event\ContactPersonUpdated;
use workbench\webb\Storage\ContactPersonRepository;
use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateContactPersonHandlerSpec extends ObjectBehavior
{
    function let(ContactPersonRepository $contactPersonRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setContactPersonRepository($contactPersonRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateContactPersonHandler::class);
    }

    function it_handles_updates(ContactPersonInterface $contactPerson, $contactPersonRepository, $dispatcher)
    {
        $contactPerson->getId()->willReturn('1');

        $contactPersonRepository->updateContactPerson($contactPerson)->shouldBeCalled();
        $dispatcher->dispatch(new ContactPersonUpdated($contactPerson->getWrappedObject()))->shouldBeCalled();

        $this->handle(new UpdateContactPerson($contactPerson->getWrappedObject()));
    }
}
