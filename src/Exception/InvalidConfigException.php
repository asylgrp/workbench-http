<?php

declare(strict_types = 1);

namespace workbench\webb\Exception;

use workbench\webb\Exception;

/**
 * Exception thrown when configuration is missing or invalid
 */
final class InvalidConfigException extends \RuntimeException implements Exception
{
}
