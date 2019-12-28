<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\CommandBus\CreateContactPerson;
use workbench\webb\DependencyInjection;
use workbench\webb\Exception\RuntimeException;
use asylgrp\decisionmaker\ContactPerson\ActiveContactPerson;
use byrokrat\banking\AccountFactoryInterface;
use inroutephp\inroute\Annotations\BasePath;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Annotations\POST;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

// TODO test...

/**
 * @BasePath(path="/contacts")
 */
final class Contact extends AbstractRoute
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\ValidatorProperty;

    private AccountFactoryInterface $accountFactory;

    public function __construct(AccountFactoryInterface $accountFactory)
    {
        $this->accountFactory = $accountFactory;
    }

    /**
     * @GET(path="/new")
     */
    public function newContactForm(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('contact-form');
    }

    /**
     * @POST(path="/new")
     */
    public function newContactTarget(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $input = $request->getParsedBody();

        // TODO skriv en mer komplett valideringslösning, det är värt det!
        $validations = [
            'name' => $this->validator->validateName($input['name'] ?? ''),
            'account' => $this->validator->validateAccount($input['account'] ?? ''),
            'mail' => $this->validator->validateMail($input['mail'] ?? ''),
            'phone' => $this->validator->validatePhone($input['phone'] ?? ''),
            'comment' => $this->validator->validateComment($input['comment'] ?? ''),
        ];

        $data = ['valid' => [], 'errors' => []];

        foreach ($validations as $key => $result) {
            $data[$result->isValid() ? 'valid' : 'errors'][$key] = $result->getData();
        }

        if ($data['errors']) {
            return $this->render(
                'contact-form',
                [
                    'alert:error' => ["Kontaktperson kunde ej sparas, se felmeddelanden nedan"],
                    'form:data' => $data['valid'],
                    'form:error' => $data['errors'],
                ]
            );
        }

        try {
            $contact = ActiveContactPerson::fromId(Uuid::uuid1()->toString())
                ->withName($data['valid']['name'])
                ->withAccount($this->accountFactory->createAccount($data['valid']['account']))
                ->withMail($data['valid']['mail'])
                ->withPhone($data['valid']['phone'])
                ->withComment($data['valid']['comment']);

            $this->commandBus->handle(new CreateContactPerson($contact));

            return $this->render(
                'contact-form',
                ['alert:success' => ["Ny kontaktperson <b>{$data['valid']['name']}</b> sparades"]]
            );
        } catch (RuntimeException $e) {
            return $this->render(
                'contact-form',
                [
                    'alert:error' => [$e->getMessage()],
                    'form:data' => $data['valid'],
                ]
            );
        }
    }

    /**
     * @GET(path="/{id}")
     */
    public function describeContact(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        // TODO presentation av massa mer data om contact
            // aktiva claims
            // historik
            // gamla decisions..
            // byta namn på Storage => Db?
            // https://matthiasnoback.nl/2018/01/simple-cqrs-reduce-coupling-allow-the-model-to-evolve/

        // TODO lyft ut till egen klass..

        return $this->render('contact-form', []);
    }

    /**
     * @GET(path="/{id}/edit")
     */
    public function editContactForm(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        // TODO validera path id med $this->validator
        $request->getAttribute('id');

        // TODO hämta data från db och presentera
        return $this->render('contact-form', []);
    }

    /**
     * @POST(path="/{id}/edit")
     */
    public function editContactTarget(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        /*
        // För att få template att rendera rätt status som selected..
        $data['valid']['status'] = [
            ($data['valid']['status'] ?? 'ACTIVE') => 'selected'
        ];
         */

        return $this->render('contact-form', []);
    }

    /**
     * @POST(path="/{id}/delete")
     */
    public function deleteContactTarget(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('contact-form', []);
    }
}
