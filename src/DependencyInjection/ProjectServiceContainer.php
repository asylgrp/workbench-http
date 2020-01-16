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
        $this->syntheticIds = [
            'Psr\\Container\\ContainerInterface' => true,
        ];
        $this->methodMap = [
            'Psr\\Http\\Message\\ResponseFactoryInterface' => 'getResponseFactoryInterfaceService',
            'Psr\\Http\\Server\\RequestHandlerInterface' => 'getRequestHandlerInterfaceService',
            'workbench\\webb\\Http\\Route\\Billboard' => 'getBillboardService',
            'workbench\\webb\\Http\\Route\\Claims' => 'getClaimsService',
            'workbench\\webb\\Http\\Route\\ContactCreate' => 'getContactCreateService',
            'workbench\\webb\\Http\\Route\\ContactDelete' => 'getContactDeleteService',
            'workbench\\webb\\Http\\Route\\ContactRead' => 'getContactReadService',
            'workbench\\webb\\Http\\Route\\ContactUpdate' => 'getContactUpdateService',
            'workbench\\webb\\Http\\Route\\Contacts' => 'getContactsService',
            'workbench\\webb\\Http\\Route\\Decisions' => 'getDecisionsService',
            'workbench\\webb\\Http\\Route\\Log' => 'getLogService',
            'workbench\\webb\\Http\\Route\\Resources' => 'getResourcesService',
            'workbench\\webb\\Http\\Route\\SignOut' => 'getSignOutService',
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
            'Mustache_Engine' => true,
            'Mustache_Loader_FilesystemLoader' => true,
            'Psr\\EventDispatcher\\EventDispatcherInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'access_logger' => true,
            'access_logger_stream' => true,
            'asylgrp\\decisionmaker\\Normalizer\\ContactPersonNormalizer' => true,
            'byrokrat\\banking\\AccountFactoryInterface' => true,
            'event_logger' => true,
            'event_logger_stream' => true,
            'workbench\\webb\\CommandBus\\CommandBus' => true,
            'workbench\\webb\\CommandBus\\Commit' => true,
            'workbench\\webb\\CommandBus\\CommitHandler' => true,
            'workbench\\webb\\CommandBus\\CreateContactPerson' => true,
            'workbench\\webb\\CommandBus\\CreateContactPersonHandler' => true,
            'workbench\\webb\\CommandBus\\DeleteContactPerson' => true,
            'workbench\\webb\\CommandBus\\DeleteContactPersonHandler' => true,
            'workbench\\webb\\CommandBus\\LoggingMiddleware' => true,
            'workbench\\webb\\CommandBus\\Rollback' => true,
            'workbench\\webb\\CommandBus\\RollbackHandler' => true,
            'workbench\\webb\\CommandBus\\UpdateContactPerson' => true,
            'workbench\\webb\\CommandBus\\UpdateContactPersonHandler' => true,
            'workbench\\webb\\Event\\Listener\\LoggingListener' => true,
            'workbench\\webb\\Exception\\AccountNumberAlreadyExistException' => true,
            'workbench\\webb\\Exception\\ContactPersonAlreadyExistException' => true,
            'workbench\\webb\\Exception\\ContactPersonDoesNotExistException' => true,
            'workbench\\webb\\Exception\\InvalidConfigException' => true,
            'workbench\\webb\\Exception\\RuntimeException' => true,
            'workbench\\webb\\Http\\HttpRouter' => true,
            'workbench\\webb\\Http\\Middleware\\Committer' => true,
            'workbench\\webb\\Http\\Middleware\\ExceptionEndpoint' => true,
            'workbench\\webb\\Http\\Middleware\\ExceptionLogger' => true,
            'workbench\\webb\\Http\\Middleware\\ExceptionPrettifier' => true,
            'workbench\\webb\\Storage\\ContactPersonRepository' => true,
            'workbench\\webb\\Storage\\TransactionHandlerInterface' => true,
            'workbench\\webb\\Storage\\Yayson\\YaysonContactPersonRepository' => true,
            'workbench\\webb\\Storage\\Yayson\\YaysonTransactionHandler' => true,
            'workbench\\webb\\Storage\\Yayson\\YaysondbFactory' => true,
            'workbench\\webb\\Utils\\MustacheConfigurator' => true,
            'workbench\\webb\\Utils\\Validators' => true,
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
        $b = new \workbench\webb\Http\Middleware\Committer();
        $b->setCommandBus(($this->privates['workbench\\webb\\CommandBus\\CommandBus'] ?? $this->getCommandBusService()));
        $c = new \Monolog\Logger('access');
        $c->pushHandler(new \Monolog\Handler\StreamHandler($this->getEnv('WORKB_BASE_DIR').'/'.$this->getEnv('string:WORKB_ACCESS_LOG')));

        $d = new \Middlewares\AccessLog($c);
        $d->format($this->getEnv('WORKB_ACCESS_FORMAT'));
        $e = new \workbench\webb\Http\HttpRouter();
        $e->setContainer(($this->services['Psr\\Container\\ContainerInterface'] ?? $this->get('Psr\\Container\\ContainerInterface', 1)));

        return $this->services['Psr\\Http\\Server\\RequestHandlerInterface'] = new \inroutephp\inroute\Runtime\Middleware\Pipeline(new \workbench\webb\Http\Middleware\ExceptionEndpoint($a), new \workbench\webb\Http\Middleware\ExceptionPrettifier(), new \workbench\webb\Http\Middleware\ExceptionLogger(($this->privates['event_logger'] ?? $this->getEventLoggerService())), $b, $d, new \Middlewares\TrailingSlash(), new \Middlewares\Robots(false, $a), $e);
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\Billboard' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\Billboard
     */
    protected function getBillboardService()
    {
        $this->services['workbench\\webb\\Http\\Route\\Billboard'] = $instance = new \workbench\webb\Http\Route\Billboard();

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\Claims' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\Claims
     */
    protected function getClaimsService()
    {
        $this->services['workbench\\webb\\Http\\Route\\Claims'] = $instance = new \workbench\webb\Http\Route\Claims();

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\ContactCreate' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\ContactCreate
     */
    protected function getContactCreateService()
    {
        $this->services['workbench\\webb\\Http\\Route\\ContactCreate'] = $instance = new \workbench\webb\Http\Route\ContactCreate(($this->privates['byrokrat\\banking\\AccountFactoryInterface'] ?? ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())));

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));
        $instance->setCommandBus(($this->privates['workbench\\webb\\CommandBus\\CommandBus'] ?? $this->getCommandBusService()));
        $instance->setEventDispatcher(($this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\ContactDelete' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\ContactDelete
     */
    protected function getContactDeleteService()
    {
        $this->services['workbench\\webb\\Http\\Route\\ContactDelete'] = $instance = new \workbench\webb\Http\Route\ContactDelete();

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));
        $instance->setCommandBus(($this->privates['workbench\\webb\\CommandBus\\CommandBus'] ?? $this->getCommandBusService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\ContactRead' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\ContactRead
     */
    protected function getContactReadService()
    {
        $this->services['workbench\\webb\\Http\\Route\\ContactRead'] = $instance = new \workbench\webb\Http\Route\ContactRead();

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\ContactUpdate' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\ContactUpdate
     */
    protected function getContactUpdateService()
    {
        $this->services['workbench\\webb\\Http\\Route\\ContactUpdate'] = $instance = new \workbench\webb\Http\Route\ContactUpdate(($this->privates['byrokrat\\banking\\AccountFactoryInterface'] ?? ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())));

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));
        $instance->setCommandBus(($this->privates['workbench\\webb\\CommandBus\\CommandBus'] ?? $this->getCommandBusService()));
        $instance->setEventDispatcher(($this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\Contacts' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\Contacts
     */
    protected function getContactsService()
    {
        $this->services['workbench\\webb\\Http\\Route\\Contacts'] = $instance = new \workbench\webb\Http\Route\Contacts();

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));
        $instance->setContactPersonRepository(($this->privates['workbench\\webb\\Storage\\ContactPersonRepository'] ?? $this->getContactPersonRepositoryService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\Decisions' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\Decisions
     */
    protected function getDecisionsService()
    {
        $this->services['workbench\\webb\\Http\\Route\\Decisions'] = $instance = new \workbench\webb\Http\Route\Decisions();

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\Log' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\Log
     */
    protected function getLogService()
    {
        $this->services['workbench\\webb\\Http\\Route\\Log'] = $instance = new \workbench\webb\Http\Route\Log($this->getEnv('WORKB_BASE_DIR').'/'.$this->getEnv('string:WORKB_EVENT_LOG'));

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));

        return $instance;
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\Resources' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\Resources
     */
    protected function getResourcesService()
    {
        return $this->services['workbench\\webb\\Http\\Route\\Resources'] = new \workbench\webb\Http\Route\Resources();
    }

    /**
     * Gets the public 'workbench\webb\Http\Route\SignOut' shared autowired service.
     *
     * @return \workbench\webb\Http\Route\SignOut
     */
    protected function getSignOutService()
    {
        $this->services['workbench\\webb\\Http\\Route\\SignOut'] = $instance = new \workbench\webb\Http\Route\SignOut();

        $instance->setMustacheEngine(($this->privates['Mustache_Engine'] ?? $this->getMustacheEngineService()));

        return $instance;
    }

    /**
     * Gets the private 'Mustache_Engine' shared autowired service.
     *
     * @return \Mustache_Engine
     */
    protected function getMustacheEngineService()
    {
        $this->privates['Mustache_Engine'] = $instance = new \Mustache_Engine(['loader' => new \Mustache_Loader_FilesystemLoader('templates')]);

        (new \workbench\webb\Utils\MustacheConfigurator())->configureMustache($instance);

        return $instance;
    }

    /**
     * Gets the private 'Psr\EventDispatcher\EventDispatcherInterface' shared autowired service.
     *
     * @return \Crell\Tukio\Dispatcher
     */
    protected function getEventDispatcherInterfaceService()
    {
        $a = new \Fig\EventDispatcher\AggregateProvider();

        $b = new \Crell\Tukio\OrderedListenerProvider(($this->services['Psr\\Container\\ContainerInterface'] ?? $this->get('Psr\\Container\\ContainerInterface', 1)));
        $b->addListener(new \workbench\webb\Event\Listener\LoggingListener(($this->privates['event_logger'] ?? $this->getEventLoggerService())));

        $a->addProvider($b);

        return $this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'] = new \Crell\Tukio\Dispatcher($a);
    }

    /**
     * Gets the private 'event_logger' shared autowired service.
     *
     * @return \Monolog\Logger
     */
    protected function getEventLoggerService()
    {
        $this->privates['event_logger'] = $instance = new \Monolog\Logger('event');

        $instance->pushHandler(new \Monolog\Handler\StreamHandler($this->getEnv('WORKB_BASE_DIR').'/'.$this->getEnv('string:WORKB_EVENT_LOG'), $this->getEnv('WORKB_LOG_LEVEL')));

        return $instance;
    }

    /**
     * Gets the private 'workbench\webb\CommandBus\CommandBus' shared autowired service.
     *
     * @return \workbench\webb\CommandBus\CommandBus
     */
    protected function getCommandBusService()
    {
        $a = new \workbench\webb\CommandBus\LoggingMiddleware();

        $b = ($this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService());

        $a->setEventDispatcher($b);
        $c = $this->getTransactionHandlerInterfaceService();

        $d = new \workbench\webb\CommandBus\CommitHandler($c);
        $d->setEventDispatcher($b);
        $e = new \workbench\webb\CommandBus\RollbackHandler($c);
        $e->setEventDispatcher($b);
        $f = new \workbench\webb\CommandBus\CreateContactPersonHandler();

        $g = ($this->privates['workbench\\webb\\Storage\\ContactPersonRepository'] ?? $this->getContactPersonRepositoryService());

        $f->setContactPersonRepository($g);
        $f->setEventDispatcher($b);
        $h = new \workbench\webb\CommandBus\DeleteContactPersonHandler();
        $h->setContactPersonRepository($g);
        $h->setEventDispatcher($b);
        $i = new \workbench\webb\CommandBus\UpdateContactPersonHandler();
        $i->setContactPersonRepository($g);
        $i->setEventDispatcher($b);

        return $this->privates['workbench\\webb\\CommandBus\\CommandBus'] = new \workbench\webb\CommandBus\CommandBus(new \League\Tactician\CommandBus([0 => $a, 1 => new \League\Tactician\Handler\CommandHandlerMiddleware(new \League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor(), new \League\Tactician\Handler\Locator\InMemoryLocator(['workbench\\webb\\CommandBus\\Commit' => $d, 'workbench\\webb\\CommandBus\\Rollback' => $e, 'workbench\\webb\\CommandBus\\CreateContactPerson' => $f, 'workbench\\webb\\CommandBus\\DeleteContactPerson' => $h, 'workbench\\webb\\CommandBus\\UpdateContactPerson' => $i]), new \League\Tactician\Handler\MethodNameInflector\HandleInflector())]));
    }

    /**
     * Gets the private 'workbench\webb\Storage\ContactPersonRepository' shared autowired service.
     *
     * @return \workbench\webb\Storage\Yayson\YaysonContactPersonRepository
     */
    protected function getContactPersonRepositoryService()
    {
        return $this->privates['workbench\\webb\\Storage\\ContactPersonRepository'] = ($this->privates['workbench\\webb\\Storage\\Yayson\\YaysondbFactory'] ?? ($this->privates['workbench\\webb\\Storage\\Yayson\\YaysondbFactory'] = new \workbench\webb\Storage\Yayson\YaysondbFactory($this->getEnv('WORKB_BASE_DIR').'/'.$this->getEnv('string:WORKB_DSN'))))->createContactPersonRepository(new \asylgrp\decisionmaker\Normalizer\ContactPersonNormalizer(($this->privates['byrokrat\\banking\\AccountFactoryInterface'] ?? ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory()))));
    }

    /**
     * Gets the private 'workbench\webb\Storage\TransactionHandlerInterface' shared autowired service.
     *
     * @return \workbench\webb\Storage\Yayson\YaysonTransactionHandler
     */
    protected function getTransactionHandlerInterfaceService()
    {
        return ($this->privates['workbench\\webb\\Storage\\Yayson\\YaysondbFactory'] ?? ($this->privates['workbench\\webb\\Storage\\Yayson\\YaysondbFactory'] = new \workbench\webb\Storage\Yayson\YaysondbFactory($this->getEnv('WORKB_BASE_DIR').'/'.$this->getEnv('string:WORKB_DSN'))))->createTransactionHandler();
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
            'env(WORKB_DSN)' => 'data',
            'env(WORKB_ACCESS_LOG)' => 'access-log.txt',
            'env(WORKB_ACCESS_FORMAT)' => '%h %u %t %T "%r" %>s %b',
            'env(WORKB_EVENT_LOG)' => 'event-log.txt',
            'env(WORKB_LOG_LEVEL)' => 'notice',
        ];
    }
}
