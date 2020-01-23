<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\Utils\Validators;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ContactPayouts extends AbstractRoute
{
    /**
     * @GET(path="/contacts/{id}/payouts", name="contact-payouts")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $id = Validators::idValidator()->validate($request->getAttribute('id'));

        // TODO implement contact-payouts

        return $this->render('contact-payouts', $request, $env, []);
    }

}
