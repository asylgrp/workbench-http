<?php

declare(strict_types = 1);

namespace workbench\webb\Config;

final class BaseDirReader
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getBaseDir(): string
    {
        return dirname($this->path);
    }
}
