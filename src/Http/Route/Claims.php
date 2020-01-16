<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Annotations\POST;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Claims extends AbstractRoute
{
    /**
     * @GET(path="/claims", name="claims")
     */
    public function list(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('claim-list', $request, $env);
    }

    /**
     * @GET(path="/forms/new-claim", name="new-claim-form")
     */
    public function newForm(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render(
            'claim-form',
            $request,
            $env,
            ['form:target' => $env->getUrlGenerator()->generateUrl('claims')]
        );
    }

    /**
     * @POST(path="/claims")
     */
    public function createNew(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('claim-form', $request, $env);
    }

    /**
     * @GET(path="/claims/{id}", name="claim")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('claim-form', $request, $env);
    }

    /**
     * @POST(path="/claims/{id}/delete", name="claim-delete")
     */
    public function delete(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('claim-form', $request, $env);
    }

    /**
     * @POST(path="/clear-claims", name="clear-claims")
     */
    public function purge(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('claim-form', $request, $env);
    }
}
