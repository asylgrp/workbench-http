<?php

declare(strict_types = 1);

namespace workbench\webb\Config;

use workbench\webb\Exception\InvalidConfigException;

final class ConfigManager
{
    private array $configs = [];

    public function __construct(RepositoryInterface ...$repos)
    {
        foreach ($repos as $repo) {
            $this->loadRepository($repo);
        }
    }

    public function loadRepository(RepositoryInterface $configs): void
    {
        $this->configs = array_merge($this->configs, $configs->getConfigs());
    }

    public function getConfig(string $name): string
    {
        if (!isset($this->configs[$name])) {
            throw new InvalidConfigException("Configuration for '$name' missing.");
        }

        $value = $this->configs[$name];

        if (!is_string($value)) {
            throw new InvalidConfigException("Configuration '$name' must be string, found: " . gettype($value));
        }

        $value = preg_replace_callback(
            '/%([^%]+)%/',
            function ($matches) {
                return $this->getConfig($matches[1]);
            },
            $value
        );

        return (string)$value;
    }
}
