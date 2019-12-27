<?php

namespace workbench\webb\Validation;

interface ResultInterface
{
    public function isValid(): bool;
    public function getData(): string;
}
