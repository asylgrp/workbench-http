<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\DependencyInjection\MustacheProperty;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class Log
{
    use MustacheProperty;

    /**
     * @GET(path="/log")
     */
    public function list(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new HtmlResponse($this->mustache->render('log', []));
    }
}
