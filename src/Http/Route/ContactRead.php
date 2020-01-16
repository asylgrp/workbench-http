<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\Utils\Validators;
use hanneskod\clean\ArrayValidator;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ContactRead extends AbstractRoute
{
    /**
     * @GET(path="/contacts/{id}", name="contact")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $id = Validators::idValidator()->validate($request->getAttribute('id'));

        // TODO hämta data från db
        $data = [];

        // TODO presentation av massa mer data om contact
            // link till delete
            // link till edit
            // form för edit..
            // aktiva claims
            // historik
            // gamla decisions..
            // byta namn på Storage => Db?
            // https://matthiasnoback.nl/2018/01/simple-cqrs-reduce-coupling-allow-the-model-to-evolve/

        return $this->render('contact', $request, $env, $data);
    }
}
