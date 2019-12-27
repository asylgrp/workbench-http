<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use workbench\webb\DependencyInjection\ProjectServiceContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

$container = new ProjectServiceContainer;

$container->set(ContainerInterface::class, $container);

(new SapiEmitter)->emit(
    $container->get(RequestHandlerInterface::class)->handle(
        ServerRequestFactory::fromGlobals()
    )
);
