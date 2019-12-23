<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use inroutephp\inroute\Annotations\BasePath;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Annotations\POST;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * @BasePath(path="/contacts")
 */
final class Contacts
{
    /**
     * @GET(path="")
     */
    public function list(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new HtmlResponse('<html><body><main>varför???</main></body></html>');
    }

    /**
     * @POST(path="")
     */
    public function create(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new TextResponse('index');
    }

    /**
     * @GET(path="/{id}")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new TextResponse('index');
    }

    /**
     * @POST(path="/{id}")
     */
    public function update(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new TextResponse('index');
    }

    /**
     * @POST(path="/{id}/delete")
     */
    public function delete(ServerRequestInterface $request, EnvironmentInterface $environment): ResponseInterface
    {
        return new TextResponse('index');
    }
}
