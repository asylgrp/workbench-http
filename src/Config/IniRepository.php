<?php

declare(strict_types = 1);

namespace workbench\webb\Config;

use workbench\webb\Exception\InvalidConfigException;

final class IniRepository implements RepositoryInterface
{
    /**
     * @var array
     */
    private $configs;

    public function __construct(string $ini)
    {
        $configs = @parse_ini_string($ini);

        if (false === $configs) {
            throw new InvalidConfigException('Unable to parse ini file');
        }

        $this->configs = $configs;
    }

    public function getConfigs(): array
    {
        return $this->configs;
    }
}
