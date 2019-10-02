<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Utils;

use workbench\webb\Utils\LoggerFactory;
use Psr\Log\LoggerInterface;
use PhpSpec\ObjectBehavior;

class LoggerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LoggerFactory::class);
    }

    function it_creates_logger()
    {
        $filename = __DIR__ . '/log.txt';
        $this->createLogger($filename, 'LEVEL', 'FORMAT')->shouldHaveType(LoggerInterface::class);
        unlink($filename);
    }
}
