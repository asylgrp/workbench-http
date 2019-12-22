<?php

declare(strict_types = 1);

namespace workbench\webb\DependencyInjection;

use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Use this trait to automatically inject an event dispatcher
 */
trait DispatcherProperty
{
    protected EventDispatcherInterface $dispatcher;

    /**
     * @required
     */
    public function setEventDispatcher(EventDispatcherInterface $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }
}
