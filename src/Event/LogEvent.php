<?php

declare(strict_types = 1);

namespace workbench\webb\Event;

use Psr\Log\LogLevel;

class LogEvent
{
    private const LOG_LEVEL_MAP = [
        LogLevel::EMERGENCY => 8,
        LogLevel::ALERT => 7,
        LogLevel::CRITICAL => 6,
        LogLevel::ERROR => 5,
        LogLevel::WARNING => 4,
        LogLevel::NOTICE => 3,
        LogLevel::INFO => 2,
        LogLevel::DEBUG => 1,
    ];

    private string $message;

    /** @var array<string, string> */
    private array $context;

    private string $severity;

    /**
     * @param array<string, string> $context
     */
    public function __construct(string $message, array $context = [], string $severity = LogLevel::NOTICE)
    {
        if (!isset(self::LOG_LEVEL_MAP[$severity])) {
            throw new \LogicException("Invalid severity, use one of the psr3 LogLevel constants");
        }

        $this->message = $message;
        $this->context = $context;
        $this->severity = $severity;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array<string, string>
     */
    public function getContext(): array
    {
        return $this->context;
    }

    public function getSeverity(): string
    {
        return $this->severity;
    }
}
