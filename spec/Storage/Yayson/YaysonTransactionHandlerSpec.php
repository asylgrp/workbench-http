<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Storage\Yayson;

use workbench\webb\Storage\Yayson\YaysonTransactionHandler;
use workbench\webb\Storage\TransactionHandlerInterface;
use hanneskod\yaysondb\Yaysondb;
use hanneskod\yaysondb\Engine\FlysystemEngine;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YaysonTransactionHandlerSpec extends ObjectBehavior
{
    private Yaysondb $yaysondb;

    function let()
    {
        $fs = new Filesystem(new MemoryAdapter);
        $fs->write('foo', '');

        $this->yaysondb = new Yaysondb([
            'foo' => new FlysystemEngine('foo', $fs)
        ]);

        $this->beConstructedWith($this->yaysondb);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(YaysonTransactionHandler::class);
    }

    function it_is_a_transaction_handler()
    {
        $this->shouldHaveType(TransactionHandlerInterface::class);
    }

    function it_does_not_commit_on_no_transaction()
    {
        $this->commit()->shouldReturn(false);
    }

    function it_does_not_rollback_on_no_transaction()
    {
        $this->rollback()->shouldReturn(false);
    }

    function it_can_commit_transaction()
    {
        $this->yaysondb->collection('foo')->insert(['data']);
        $this->commit()->shouldReturn(true);
        $this->commit()->shouldReturn(false);
    }

    function it_can_rollback_transaction()
    {
        $this->yaysondb->collection('foo')->insert(['data']);
        $this->rollback()->shouldReturn(true);
        $this->rollback()->shouldReturn(false);
    }
}
