<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use workbench\webb\DependencyInjection\ProjectServiceContainer;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

(new SapiEmitter)->emit(
    (new ProjectServiceContainer)->get(RequestHandlerInterface::class)->handle(
        ServerRequestFactory::fromGlobals()
    )
);
