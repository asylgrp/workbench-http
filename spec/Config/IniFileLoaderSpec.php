<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Config;

use workbench\webb\Config\IniFileLoader;
use workbench\webb\Config\ConfigManager;
use workbench\webb\Config\IniRepository;
use workbench\webb\Exception\InvalidConfigException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IniFileLoaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(IniFileLoader::class);
    }

    function it_loads_configs()
    {
        $this->beConstructedWith(__DIR__ . '/testdata.ini');

        $manager = new ConfigManager;

        $this->loadIniFile($manager);

        if ($manager->getConfig('foo') != 'bar') {
            throw new \Exception('Expecting ini file to be loaded');
        }
    }

    function it_throws_on_missing_config_file()
    {
        $this->beConstructedWith('does-not-exist');
        $this->shouldThrow(InvalidConfigException::class)->duringLoadIniFile(new ConfigManager);
    }
}
