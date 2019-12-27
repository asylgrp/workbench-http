<?php

declare(strict_types = 1);

namespace workbench\webb\CommandBus;

use workbench\webb\DependencyInjection\DispatcherProperty;
use workbench\webb\Event\LogEvent;
use League\Tactician\Middleware;
use Psr\Log\LogLevel;

final class LoggingMiddleware implements Middleware
{
    use DispatcherProperty;

    public function execute($command, callable $next)
    {
        $commandClass = get_class($command);

        $this->dispatcher->dispatch(
            new LogEvent("Enter command $commandClass", [], LogLevel::DEBUG)
        );

        $returnValue = $next($command);

        $this->dispatcher->dispatch(
            new LogEvent("Command $commandClass finished without errors", [], LogLevel::DEBUG)
        );

        return $returnValue;
    }
}
