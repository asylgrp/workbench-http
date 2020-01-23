<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\CommandBus\UpdateContactPerson;
use workbench\webb\DependencyInjection;
use workbench\webb\Event\LogEvent;
use workbench\webb\Utils\Validators;
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
    use DependencyInjection\ContactPersonRepositoryProperty,
        DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty;

    private const ACTIVE = 'ACTIVE';
    private const BLOCKED = 'BLOCKED';
    private const BANNED = 'BANNED';

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
        $contact = $this->contactPersonRepository->contactPersonFromId(
            Validators::idValidator()->validate($request->getAttribute('id'))
        );

        $data = [
            'id' => $contact->getId(),
            'status' => $contact->isActive() ? self::ACTIVE : ($contact->isBlocked() ? self::BLOCKED : self::BANNED),
            'name' => $contact->getName(),
            'account' => $contact->getAccount(),
            'mail' => $contact->getMail(),
            'phone' => $contact->getPhone(),
            'comment' => $contact->getComment(),
        ];

        return $this->renderForm(
            $request,
            $env,
            $data
        );


        return $this->render(
            'contact-form',
            $request,
            $env,
            [
                'form:target' => $env->getUrlGenerator()->generateUrl('contact', ['id' => $contact->getId()]),
                'form:data' => $data,
            ]
        );
    }

    /**
     * @POST(path="/contacts/{id}")
     */
    public function post(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $validator = new ArrayValidator([
            'status' => Validators::statusValidator(),
            'name' => Validators::nameValidator(),
            'account' => Validators::accountValidator(),
            'mail' => Validators::mailValidator(),
            'phone' => Validators::phoneValidator(),
            'comment' => Validators::textValidator(),
        ]);

        $result = $validator->applyTo($request->getParsedBody());

        if (!$result->isValid()) {
            return $this->renderForm(
                $request,
                $env,
                $result->getValidData(),
                ["Kontaktperson kunde ej sparas, se felmeddelanden nedan"],
                $result->getErrors()
            );
        }

        $input = [];

        try {
            $input = $result->getValidData();

            $contact = $this->contactPersonRepository->contactPersonFromId(
                Validators::idValidator()->validate($request->getAttribute('id'))
            );

            $contact = $contact
                ->withName($input['name'])
                ->withAccount($this->accountFactory->createAccount($input['account']))
                ->withMail($input['mail'])
                ->withPhone($input['phone'])
                ->withComment($input['comment']);

            switch ($input['status']) {
                case self::ACTIVE:
                    $contact = $contact->activate();
                    break;
                case self::BLOCKED:
                    $contact = $contact->block();
                    break;
                case self::BANNED:
                    $contact = $contact->ban();
                    break;
            }

            $this->commandBus->handle(new UpdateContactPerson($contact));

            return $this->redirect(
                $env->getUrlGenerator()->generateUrl('contact', ['id' => $contact->getId()]),
                'Ändringar sparades'
            );
        } catch (\RuntimeException $e) {
            $this->dispatcher->dispatch(
                new LogEvent('Unable to update contact person', ['msg' => $e->getMessage()], LogLevel::WARNING)
            );

            return $this->renderForm(
                $request,
                $env,
                $input,
                ["Kontaktperson kunde ej sparas.\n" . $e->getMessage()]
            );
        }
    }

    /**
     * @param array<string> $data
     * @param array<string> $errorMessages
     * @param array<string> $formErrors
     */
    private function renderForm(
        ServerRequestInterface $request,
        EnvironmentInterface $env,
        array $data,
        array $errorMessages = [],
        array $formErrors = []
    ): ResponseInterface {
        $id = Validators::idValidator()->validate($request->getAttribute('id'));

        $data['id'] = $id;

        $status = $data['status'] ?: '';

        $data['status'] = [
            self::ACTIVE => $status == self::ACTIVE ? 'selected' : '',
            self::BLOCKED => $status == self::BLOCKED ? 'selected' : '',
            self::BANNED => $status == self::BANNED ? 'selected' : '',
        ];

        return $this->render(
            'contact-form',
            $request,
            $env,
            [
                'alert:error' => $errorMessages,
                'form:target' => $env->getUrlGenerator()->generateUrl('contact', ['id' => $id]),
                'form:data' => $data,
                'form:error' => $formErrors,
            ]
        );
    }
}
