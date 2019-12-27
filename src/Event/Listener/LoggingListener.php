<?php

declare(strict_types = 1);

namespace workbench\webb\Event\Listener;

use workbench\webb\Event\LogEvent;
use Psr\Log\LoggerInterface;

final class LoggingListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(LogEvent $event): void
    {
        $this->logger->log($event->getSeverity(), $event->getMessage(), $event->getContext());
    }
}
