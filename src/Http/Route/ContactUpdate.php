<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\CommandBus\CreateContactPerson;
use workbench\webb\DependencyInjection;
use workbench\webb\Event\LogEvent;
use workbench\webb\Utils\Validators;
use asylgrp\decisionmaker\ContactPerson\ActiveContactPerson;
use byrokrat\banking\AccountFactoryInterface;
use hanneskod\clean\ArrayValidator;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Annotations\POST;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;

final class ContactUpdate extends AbstractRoute
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty;

    private AccountFactoryInterface $accountFactory;

    public function __construct(AccountFactoryInterface $accountFactory)
    {
        $this->accountFactory = $accountFactory;
    }

    /**
     * @GET(path="/forms/edit-contact/{id}", name="edit-contact-form")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $id = Validators::idValidator()->validate($request->getAttribute('id'));

        // TODO hämta data från db
        $data = [];

        return $this->render(
            'contact-form',
            $request,
            $env,
            [
                'form:target' => $env->getUrlGenerator()->generateUrl('contact', ['id' => $id]),
                'form:data' => $data,
            ]
        );
    }

    /**
     * @POST(path="/contacts/{id}")
     */
    public function post(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        /*
        // För att få template att rendera rätt status som selected..
        $input['status'] = [
            ($input['status'] ?? 'ACTIVE') => 'selected'
        ];
         */

        $id = Validators::idValidator()->validate($request->getAttribute('id'));

        // TODO spara ändringar...
        $data = [];

        return $this->redirect(
            $env->getUrlGenerator()->generateUrl('contact', ['id' => $id]),
            'Ändringar sparades'
        );

        // TODO render on fail...
        return $this->render(
            'contact-form',
            $request,
            $env,
            [
                'form:target' => $env->getUrlGenerator()->generateUrl('contact', ['id' => $id]),
                'form:data' => $data,
            ]
        );
    }
}
