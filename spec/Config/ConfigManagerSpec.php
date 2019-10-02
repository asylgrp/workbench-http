<?php

declare(strict_types = 1);

namespace spec\workbench\webb\Config;

use workbench\webb\Config\ConfigManager;
use workbench\webb\Config\RepositoryInterface;
use workbench\webb\Exception\InvalidConfigException;
use PhpSpec\ObjectBehavior;

class ConfigManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ConfigManager::class);
    }

    function it_can_read_configs(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => 'bar']);
        $this->loadRepository($repo);
        $this->getConfig('foo')->shouldReturn('bar');
    }

    function it_can_load_configs_at_construct(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => 'bar']);
        $this->beConstructedWith($repo);
        $this->getConfig('foo')->shouldReturn('bar');
    }

    function it_merges_configs(RepositoryInterface $repoA, RepositoryInterface $repoB)
    {
        $repoA->getConfigs()->willReturn(['foo' => 'A', 'bar' => 'A']);
        $repoB->getConfigs()->willReturn(['foo' => 'B']);
        $this->loadRepository($repoA);
        $this->loadRepository($repoB);
        $this->getConfig('foo')->shouldReturn('B');
        $this->getConfig('bar')->shouldReturn('A');
    }

    function it_resolves_references(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([
            'foo' => '%bar%/%baz%',
            'bar' => 'a',
            'baz' => 'b',
        ]);
        $this->loadRepository($repo);
        $this->getConfig('foo')->shouldReturn('a/b');
    }

    function it_resolves_references_recursively(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([
            'foo' => '%bar%/foo',
            'bar' => '%baz%/bar',
            'baz' => 'baz',
        ]);
        $this->loadRepository($repo);
        $this->getConfig('foo')->shouldReturn('baz/bar/foo');
    }

    function it_throws_on_non_string_value(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['value-not-a-string' => 123]);
        $this->loadRepository($repo);
        $this->shouldThrow(InvalidConfigException::class)->duringGetConfig('value-not-a-string');
    }

    function it_throws_on_missing_config(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([]);
        $this->loadRepository($repo);
        $this->shouldThrow(InvalidConfigException::class)->duringGetConfig('does-not-exist');
    }
}
