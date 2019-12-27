<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\CommandBus\CreateContactPerson;
use workbench\webb\DependencyInjection;
use workbench\webb\Exception\RuntimeException;
use asylgrp\decisionmaker\Normalizer\ContactPersonNormalizer;
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

    private ContactPersonNormalizer $contactPersonNormalizer;

    public function __construct(ContactPersonNormalizer $contactPersonNormalizer)
    {
        $this->contactPersonNormalizer = $contactPersonNormalizer;
    }

    /**
     * @GET(path="/new")
     */
    public function newForm(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('contact-form');
    }

    /**
     * @POST(path="/new")
     */
    public function createNew(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $input = $request->getParsedBody();

        $validations = [
            'name' => $this->validator->validateName($input['name'] ?? ''),
            'status' => $this->validator->validateStatus($input['status'] ?? ''),
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
            $data['valid']['status'] = [
                ($data['valid']['status'] ?? 'ACTIVE') => 'selected'
            ];

            return $this->render(
                'contact-form',
                [
                    'alert:error' => ["Kontaktperson kunde ej sparas, se felmeddelanden nedan"],
                    'form:data' => $data['valid'],
                    'form:error' => $data['errors'],
                ]
            );
        }

        $data['valid']['id'] = Uuid::uuid1()->toString();

        try {
            // TODO normalizer behöver inte ta klass som argument till denormalize
            // uppdatera till economix...
            $contact = $this->contactPersonNormalizer->denormalize(
                $data['valid'],
                \asylgrp\decisionmaker\ContactPerson\ContactPersonInterface::class
            );

            $this->commandBus->handle(new CreateContactPerson($contact));

            return $this->render(
                'contact-form',
                ['alert:success' => ["Ny kontaktperson <b>{$data['valid']['name']}</b> sparades"]]
            );
        } catch (RuntimeException $e) {
            unset($data['valid']['id']);

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
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        // TODO validera path id med $this->validator
        $request->getAttribute('id');

        // TODO hämta data från db och presentera
        return $this->render('contact-form', []);
    }

    /**
     * @POST(path="/{id}")
     */
    public function update(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('contact-form', []);
    }

    /**
     * @POST(path="/{id}/delete")
     */
    public function delete(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render('contact-form', []);
    }
}
