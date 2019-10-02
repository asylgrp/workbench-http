<?php

declare(strict_types = 1);

namespace workbench\webb\Config;

use workbench\webb\Exception\InvalidConfigException;

final class IniFileLoader
{
    /**
     * @var string
     */
    private $iniFileName;

    public function __construct(string $iniFileName)
    {
        $this->iniFileName = $iniFileName;
    }

    public function loadIniFile(ConfigManager $manager): void
    {
        $content = @file_get_contents($this->iniFileName);

        if (false === $content) {
            throw new InvalidConfigException("Config file {$this->iniFileName} does not exist");
        }

        $manager->loadRepository(new IniRepository($content));
    }
}
