<?php

namespace workbench\webb\DependencyInjection;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final
 */
class ProjectServiceContainer extends Container
{
    private $parameters = [];

    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services = $this->privates = [];
        $this->methodMap = [
            'Psr\\Http\\Message\\ResponseFactoryInterface' => 'getResponseFactoryInterfaceService',
            'Psr\\Http\\Server\\RequestHandlerInterface' => 'getRequestHandlerInterfaceService',
            'ini' => 'getIniService',
        ];

        $this->aliases = [];
    }

    public function compile(): void
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled(): bool
    {
        return true;
    }

    public function getRemovedIds(): array
    {
        return [
            'Crell\\Tukio\\OrderedProviderInterface' => true,
            'Fig\\EventDispatcher\\AggregateProvider' => true,
            'League\\Tactician\\CommandBus' => true,
            'League\\Tactician\\Handler\\CommandHandlerMiddleware' => true,
            'League\\Tactician\\Handler\\CommandNameExtractor\\ClassNameExtractor' => true,
            'League\\Tactician\\Handler\\Locator\\InMemoryLocator' => true,
            'League\\Tactician\\Handler\\MethodNameInflector\\HandleInflector' => true,
            'Middlewares\\Robots' => true,
            'Middlewares\\TrailingSlash' => true,
            'Money\\Currencies' => true,
            'Money\\MoneyFormatter' => true,
            'Money\\MoneyParser' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Psr\\EventDispatcher\\EventDispatcherInterface' => true,
            'Psr\\Log\\LoggerInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'base_dir_reader' => true,
            'base_dir_repository' => true,
            'workbench\\webb\\CommandBus\\CommandBusInterface' => true,
            'workbench\\webb\\Config\\ArrayRepository' => true,
            'workbench\\webb\\Config\\BaseDirReader' => true,
            'workbench\\webb\\Config\\ConfigManager' => true,
            'workbench\\webb\\Config\\IniFileLoader' => true,
            'workbench\\webb\\Config\\IniRepository' => true,
            'workbench\\webb\\Exception' => true,
            'workbench\\webb\\Exception\\InvalidConfigException' => true,
            'workbench\\webb\\Http\\HttpRouter' => true,
            'workbench\\webb\\Http\\Middleware\\ExceptionLogger' => true,
            'workbench\\webb\\Utils\\LoggerFactory' => true,
        ];
    }

    /**
     * Gets the public 'Psr\Http\Message\ResponseFactoryInterface' shared autowired service.
     *
     * @return \Zend\Diactoros\ResponseFactory
     */
    protected function getResponseFactoryInterfaceService()
    {
        return $this->services['Psr\\Http\\Message\\ResponseFactoryInterface'] = new \Zend\Diactoros\ResponseFactory();
    }

    /**
     * Gets the public 'Psr\Http\Server\RequestHandlerInterface' shared autowired service.
     *
     * @return \inroutephp\inroute\Runtime\Middleware\Pipeline
     */
    protected function getRequestHandlerInterfaceService()
    {
        $a = new \workbench\webb\Http\HttpRouter();
        $a->setContainer(new \workbench\webb\DependencyInjection\ProjectServiceContainer());

        return $this->services['Psr\\Http\\Server\\RequestHandlerInterface'] = new \inroutephp\inroute\Runtime\Middleware\Pipeline(new \workbench\webb\Http\Middleware\ExceptionLogger((new \workbench\webb\Utils\LoggerFactory())->createLogger(($this->services['ini'] ?? $this->getIniService())->getConfig("log_file"), ($this->services['ini'] ?? $this->getIniService())->getConfig("log_level"), ($this->services['ini'] ?? $this->getIniService())->getConfig("log_format")), ($this->services['Psr\\Http\\Message\\ResponseFactoryInterface'] ?? ($this->services['Psr\\Http\\Message\\ResponseFactoryInterface'] = new \Zend\Diactoros\ResponseFactory()))), new \Middlewares\TrailingSlash(), new \Middlewares\Robots(false), $a);
    }

    /**
     * Gets the public 'ini' shared autowired service.
     *
     * @return \workbench\webb\Config\ConfigManager
     */
    protected function getIniService()
    {
        $this->services['ini'] = $instance = new \workbench\webb\Config\ConfigManager(new \workbench\webb\Config\ArrayRepository(['base_dir' => (new \workbench\webb\Config\BaseDirReader($this->getEnv('WORKBENCH_INI')))->getBaseDir()]));

        (new \workbench\webb\Config\IniFileLoader($this->getEnv('WORKBENCH_INI')))->loadIniFile($instance);

        return $instance;
    }

    public function getParameter(string $name)
    {
        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter(string $name): bool
    {
        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter(string $name, $value): void
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    public function getParameterBag(): ParameterBagInterface
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = [];
    private $dynamicParameters = [];

    private function getDynamicParameter(string $name)
    {
        throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
    }

    protected function getDefaultParameters(): array
    {
        return [
            'env(WORKBENCH_INI)' => 'workbench.ini',
        ];
    }
}
