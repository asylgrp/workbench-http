<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Db\Yayson;

use workbench\webb\Db\Yayson\YaysondbFactory;
use workbench\webb\Db\ContactPersonRepository;
use workbench\webb\Db\TransactionHandlerInterface;
use asylgrp\decisionmaker\Normalizer\ContactPersonNormalizer;

use hanneskod\yaysondb\Yaysondb;
use hanneskod\yaysondb\Engine\FlysystemEngine;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YaysondbFactorySpec extends ObjectBehavior
{
    private string $tmpdir;

    function let()
    {
        $this->tmpdir = sys_get_temp_dir() . '/' . uniqid('workbench_webb_test_');
        $this->beConstructedWith($this->tmpdir);
    }

    function letGo()
    {
        system("rm -rf ".escapeshellarg($this->tmpdir));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(YaysondbFactory::class);
    }

    function it_creates_contact_person_repositories(ContactPersonNormalizer $normalizer)
    {
        $this->createContactPersonRepository($normalizer)->shouldHaveType(ContactPersonRepository::class);
    }

    function it_create_transaction_handlers()
    {
        $this->createTransactionHandler()->shouldHaveType(TransactionHandlerInterface::class);
    }
}
