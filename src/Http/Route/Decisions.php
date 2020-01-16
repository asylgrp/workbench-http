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
 * @BasePath(path="/decisions")
 */
final class Decisions extends AbstractRoute
{
    /**
     * @GET(path="", name="decisions")
     */
    public function list(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('decisions', $request, $env);
    }

    /**
     * @POST
     */
    public function create(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('decisions', $request, $env);
    }

    /**
     * @GET(path="/{id}", name="decision")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('decisions', $request, $env);
    }
}
