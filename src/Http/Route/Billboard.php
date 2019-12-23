<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\DependencyInjection\MustacheProperty;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Annotations\POST;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class Billboard
{
    use MustacheProperty;

    /**
     * @GET(path="/", name="billboard")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new HtmlResponse($this->mustache->render('billboard', []));
    }

    /**
     * @POST(path="/")
     */
    public function post(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new HtmlResponse($this->mustache->render('billboard', []));
    }
}
