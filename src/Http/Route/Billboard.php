<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use inroutephp\inroute\Annotations\BasePath;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Annotations\POST;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @BasePath(path="/")
 */
final class Billboard extends AbstractRoute
{
    /**
     * @GET(name="billboard")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('billboard', $request, $env);
    }

    /**
     * @POST
     */
    public function post(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('billboard', $request, $env);
    }
}
