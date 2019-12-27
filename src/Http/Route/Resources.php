<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\TextResponse;

final class Resources
{
    /**
     * @GET(path="/trimmings.js", name="trimmings.js")
     */
    public function trimmings(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new TextResponse(
            (string)file_get_contents(__DIR__ . '/../../../res/trimmings.js'),
            200,
            ['Content-Type' => ['application/javascript']]
        );
    }

    /**
     * @GET(path="/bootstrap.min.css", name="bootstrap.min.css")
     */
    public function bootstrap(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new TextResponse(
            (string)file_get_contents(__DIR__ . '/../../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css'),
            200,
            ['Content-Type' => ['text/css']]
        );
    }
}
