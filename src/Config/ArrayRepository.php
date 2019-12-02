<?php

declare(strict_types = 1);

namespace workbench\webb\Config;

final class ArrayRepository implements RepositoryInterface
{
    private array $configs;

    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function getConfigs(): array
    {
        return $this->configs;
    }
}
