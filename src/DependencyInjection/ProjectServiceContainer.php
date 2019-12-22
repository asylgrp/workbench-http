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
            'workbench\\webb\\Http\\Route\\Index' => 'getIndexService',
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
            'Middlewares\\AccessLog' => true,
            'Middlewares\\Robots' => true,
            'Middlewares\\TrailingSlash' => true,
            'Money\\Currencies' => true,
            'Money\\MoneyFormatter' => true,
            'Money\\MoneyParser' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Psr\\EventDispatcher\\EventDispatcherInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'access_logger' => true,
            'access_logger_stream' => true,
            'error_logger' => true,
            'error_logger_stream' => true,
            'workbench\\webb\\CommandBus\\CommandBusInterface' => true,
            'workbench\\webb\\CommandBus\\CreateContactPerson' => true,
            'workbench\\webb\\CommandBus\\CreateContactPersonHandler' => true,
            'workbench\\webb\\CommandBus\\DeleteContactPerson' => true,
            'workbench\\webb\\CommandBus\\DeleteContactPersonHandler' => true,
            'workbench\\webb\\CommandBus\\UpdateContactPerson' => true,
            'workbench\\webb\\CommandBus\\UpdateContactPersonHandler' => true,
            'workbench\\webb\\Event\\ContactPersonCreated' => true,
            'workbench\\webb\\Event\\ContactPersonDeleted' => true,
            'workbench\\webb\\Event\\ContactPersonEvent' => true,
            'workbench\\webb\\Event\\ContactPersonUpdated' => true,
            'workbench\\webb\\Event\\LogEvent' => true,
            'workbench\\webb\\Exception\\AccountNumberAlreadyExistException' => true,
            'workbench\\webb\\Exception\\ContactPersonAlreadyExistException' => true,
            'workbench\\webb\\Exception\\ContactPersonDoesNotExistException' => true,
            'workbench\\webb\\Exception\\InvalidConfigException' => true,
            'workbench\\webb\\Http\\HttpRouter' => true,
            'workbench\\webb\\Http\\Middleware\\ExceptionEndpoint' => true,
            'workbench\\webb\\Http\\Middleware\\ExceptionLogger' => true,
            'workbench\\webb\\Http\\Middleware\\ExceptionPrettifier' => true,
            'workbench\\webb\\Storage\\ContactPersonRepositoryInterface' => true,
            'workbench\\webb\\Storage\\Json\\JsonContactPersonRepository' => true,
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
        $a = ($this->services['Psr\\Http\\Message\\ResponseFactoryInterface'] ?? ($this->services['Psr\\Http\\Message\\ResponseFactoryInterface'] = new \Zend\Diactoros\ResponseFactory()));
        $b = new \Monolog\Logger('error');
        $b->pushHandler(new \Monolog\Handler\StreamHandler($this->getEnv('WORKB_BASE_DIR').'/'.$this->getEnv('string:WORKB_ERROR_LOG'), $this->getEnv('WORKB_ERROR_LEVEL')));
        $c = new \Monolog\Logger('access');
        $c->pushHandler(new \Monolog\Handler\StreamHandler($this->getEnv('WORKB_BASE_DIR').'/'.$this->getEnv('string:WORKB_ACCESS_LOG')));

        $d = new \Middlewares\AccessLog($c);
        $d->format($this->getEnv('WORKB_ACCESS_FORMAT'));
        $e = new \workbench\webb\Http\HttpRouter();
        $e->setContainer(new \workbench\webb\DependencyInjection\ProjectServiceContainer());

        return $this->services['Psr\\Http\\Server\\RequestHandlerInterface'] = new \inroutephp\inroute\Runtime\Middleware\Pipeline(new \workbench\webb\Http\Middleware\ExceptionEndpoint($a), new \workbench\webb\Http\Middleware\ExceptionPrettifier(), new \workbench\webb\Http\Middleware\ExceptionLogger($b), $d, new \Middlewares\TrailingSlash(), new \Middlewares\Robots(false, $a), $e);
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\Index' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\Index
     */
    protected function getIndexService()
    {
        return $this->services['workbench\\webb\\Http\\Route\\Index'] = new \workbench\webb\Http\Route\Index();
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
            'env(WORKB_ORG_NAME)' => 'Unknown organization',
            'env(WORKB_BASE_DIR)' => '.',
            'env(WORKB_DECISIONS_DIR)' => 'decisions',
            'env(WORKB_ACCESS_LOG)' => 'access-log.txt',
            'env(WORKB_ACCESS_FORMAT)' => '%h %u %t %T "%r" %>s %b',
            'env(WORKB_ERROR_LOG)' => 'error-log.txt',
            'env(WORKB_ERROR_LEVEL)' => 'notice',
        ];
    }
}
