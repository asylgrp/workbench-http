<?php

declare(strict_types = 1);

namespace workbench\webb\Validation;

final class Invalid implements ResultInterface
{
    private string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function isValid(): bool
    {
        return false;
    }

    public function getData(): string
    {
        return $this->data;
    }
}
