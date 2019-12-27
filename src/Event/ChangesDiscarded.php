<?php

declare(strict_types = 1);

namespace workbench\webb\Event;

use Psr\Log\LogLevel;

final class ChangesDiscarded extends LogEvent implements DatabaseEvent
{
    public function __construct()
    {
        parent::__construct('Changes discarded', [], LogLevel::NOTICE);
    }
}
