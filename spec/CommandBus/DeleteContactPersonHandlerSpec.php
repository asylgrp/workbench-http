<?php

declare(strict_types = 1);

namespace spec\workbench\webb\CommandBus;

use workbench\webb\CommandBus\DeleteContactPersonHandler;
use workbench\webb\CommandBus\DeleteContactPerson;
use workbench\webb\Event\ContactPersonDeleted;
use workbench\webb\Storage\ContactPersonRepository;
use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteContactPersonHandlerSpec extends ObjectBehavior
{
    function let(ContactPersonRepository $contactPersonRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setContactPersonRepository($contactPersonRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteContactPersonHandler::class);
    }

    function it_handles_deletions(ContactPersonInterface $contactPerson, $contactPersonRepository, $dispatcher)
    {
        $contactPerson->getId()->willReturn('1');

        $contactPersonRepository->deleteContactPerson($contactPerson)->shouldBeCalled();
        $dispatcher->dispatch(new ContactPersonDeleted($contactPerson->getWrappedObject()))->shouldBeCalled();

        $this->handle(new DeleteContactPerson($contactPerson->getWrappedObject()));
    }
}
