<?php

declare(strict_types = 1);

namespace workbench\webb\Validation;

final class Valid implements ResultInterface
{
    private string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function isValid(): bool
    {
        return true;
    }

    public function getData(): string
    {
        return $this->data;
    }
}
