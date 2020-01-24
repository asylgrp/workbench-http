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
use Ramsey\Uuid\Uuid;

final class ContactCreate extends AbstractRoute
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty;

    private AccountFactoryInterface $accountFactory;

    public function __construct(AccountFactoryInterface $accountFactory)
    {
        $this->accountFactory = $accountFactory;
    }

    /**
     * @GET(path="/forms/new-contact", name="new-contact-form")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render(
            'contact-form',
            $request,
            $env,
            ['form:target' => $env->getUrlGenerator()->generateUrl('contacts')]
        );
    }

    /**
     * @POST(path="/contacts")
     */
    public function post(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $validator = new ArrayValidator([
            'name' => Validators::nameValidator(),
            'account' => Validators::accountValidator(),
            'mail' => Validators::mailValidator(),
            'phone' => Validators::phoneValidator(),
            'comment' => Validators::textValidator(),
        ]);

        $result = $validator->applyTo($request->getParsedBody());

        if (!$result->isValid()) {
            return $this->render(
                'contact-form',
                $request,
                $env,
                [
                    'alert:error' => ["Kontaktperson kunde ej sparas, se felmeddelanden nedan"],
                    'form:target' => $env->getUrlGenerator()->generateUrl('contacts'),
                    'form:data' => $result->getValidData(),
                    'form:error' => $result->getErrors(),
                ],
                400
            );
        }

        $input = [];

        try {
            $input = $result->getValidData();

            $contact = ActiveContactPerson::fromId(Uuid::uuid1()->toString())
                ->withName($input['name'])
                ->withAccount($this->accountFactory->createAccount($input['account']))
                ->withMail($input['mail'])
                ->withPhone($input['phone'])
                ->withComment($input['comment']);

            $this->commandBus->handle(new CreateContactPerson($contact));

            return $this->redirect(
                $env->getUrlGenerator()->generateUrl('contact', ['id' => $contact->getId()]),
                $contact->getName() . ' skapades'
            );
        } catch (\RuntimeException $e) {
            $this->dispatcher->dispatch(
                new LogEvent('Unable to create contact person', ['msg' => $e->getMessage()], LogLevel::WARNING)
            );

            return $this->render(
                'contact-form',
                $request,
                $env,
                [
                    'alert:error' => ["Kontaktperson kunde ej sparas.\n" . $e->getMessage()],
                    'form:target' => $env->getUrlGenerator()->generateUrl('contacts'),
                    'form:data' => $input,
                ],
                400
            );
        }
    }
}
