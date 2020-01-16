<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class SignOut extends AbstractRoute
{
    /**
     * @GET(path="/sign-out", name="sign-out")
     */
    public function signOut(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('log', $request, $env);
    }
}
