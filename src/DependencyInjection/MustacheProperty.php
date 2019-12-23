<?php

declare(strict_types = 1);

namespace workbench\webb\DependencyInjection;

use Mustache_Engine;

/**
 * Use this trait to automatically inject the mustache engine
 */
trait MustacheProperty
{
    protected Mustache_Engine $mustache;

    /**
     * @required
     */
    public function setMustacheEngine(Mustache_Engine $mustache): void
    {
        $this->mustache = $mustache;
    }
}
