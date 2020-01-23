<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\Utils\Validators;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ContactHistory extends AbstractRoute
{
    /**
     * @GET(path="/contacts/{id}/history", name="contact-history")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $id = Validators::idValidator()->validate($request->getAttribute('id'));

        // TODO implement contact-history

        return $this->render('contact-history', $request, $env, []);
    }
}
