<?php

declare(strict_types = 1);

namespace workbench\webb\Utils;

use Mustache_Engine;

class MustacheConfigurator
{
    public function configureMustache(Mustache_Engine $mustache): void
    {
        $mustache->addHelper('nl2br', function ($value) {
            return nl2br((string)$value);
        });
    }
}
