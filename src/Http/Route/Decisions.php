<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\DependencyInjection\MustacheProperty;
use inroutephp\inroute\Annotations\BasePath;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Annotations\POST;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * @BasePath(path="/decisions")
 */
final class Decisions
{
    use MustacheProperty;

    /**
     * @GET(path="")
     */
    public function list(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new HtmlResponse($this->mustache->render('decisions', []));
    }

    /**
     * @POST(path="")
     */
    public function create(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new HtmlResponse('');
    }

    /**
     * @GET(path="/{id}")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new HtmlResponse('');
    }

    /**
     * @POST(path="/{id}/delete")
     */
    public function delete(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new HtmlResponse('');
    }
}
