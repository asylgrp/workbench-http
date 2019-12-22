<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Event;

use workbench\webb\Event\ContactPersonEvent;
use workbench\webb\Event\LogEvent;
use asylgrp\decisionmaker\ContactPerson\ContactPersonInterface;
use Psr\Log\LogLevel;
use PhpSpec\ObjectBehavior;

class ContactPersonEventSpec extends ObjectBehavior
{
    function let(ContactPersonInterface $contactPerson)
    {
        $contactPerson->getId()->willReturn('');
        $this->beConstructedWith('', $contactPerson);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ContactPersonEvent::class);
    }

    function it_is_a_log_event()
    {
        $this->shouldHaveType(LogEvent::class);
    }

    function it_contains_a_message($contactPerson)
    {
        $this->beConstructedWith('message', $contactPerson);
        $this->getMessage()->shouldBeLike('message');
    }

    function it_contains_a_contact_person($contactPerson)
    {
        $this->getContactPerson()->shouldReturn($contactPerson);
    }

    function it_contains_a_severity()
    {
        $this->getSeverity()->shouldReturn(LogLevel::INFO);
    }

    function it_contains_an_context($contactPerson)
    {
        $contactPerson->getId()->willReturn('id');
        $this->getContext()->shouldContain('id');
    }
}
