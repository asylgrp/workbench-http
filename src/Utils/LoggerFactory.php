<?php

declare(strict_types = 1);

namespace workbench\webb\Utils;

use Psr\Log\LoggerInterface;
use Katzgrau\KLogger\Logger;

final class LoggerFactory
{
    public function createLogger(string $filename, string $level, string $format): LoggerInterface
    {
        return new Logger(dirname($filename), $level, [
            'filename' => basename($filename),
            'logFormat' => $format,
            'appendContext' => false
        ]);
    }
}
