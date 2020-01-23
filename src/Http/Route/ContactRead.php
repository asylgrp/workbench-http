<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\DependencyInjection\ContactPersonRepositoryProperty;
use workbench\webb\Utils\Validators;
use hanneskod\clean\ArrayValidator;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Octicons\Octicon;

final class ContactRead extends AbstractRoute
{
    use ContactPersonRepositoryProperty;

    /**
     * @GET(path="/contacts/{id}", name="contact")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $contact = $this->contactPersonRepository->contactPersonFromId(
            Validators::idValidator()->validate($request->getAttribute('id'))
        );

        $data = [
            'status' => '',
            'icon' => '',
            'name' => $contact->getName(),
            'account' => $contact->getAccount()->prettyprint(),
            'bank' => $contact->getAccount()->getBankName(),
            'mail' => $contact->getMail(),
            'phone' => $contact->getPhone(),
            'comment' => $contact->getComment(),
            'links' => [
                'edit' => [
                    'icon' => Octicon::pencil(),
                    'href' => $env->getUrlGenerator()->generateUrl('edit-contact-form', ['id' => $contact->getId()]),
                ],
                'delete' => [
                    'icon' => Octicon::trashcan(),
                    'href' => $env->getUrlGenerator()->generateUrl('contact-delete', ['id' => $contact->getId()]),
                ],
                'history' => [
                    'icon' => '',
                    'href' => $env->getUrlGenerator()->generateUrl('contact-history', ['id' => $contact->getId()]),
                ],
                'payouts' => [
                    'icon' => '',
                    'href' => $env->getUrlGenerator()->generateUrl('contact-payouts', ['id' => $contact->getId()]),
                ],
            ]
        ];

        if ($contact->isActive()) {
            $data['status'] = 'AKTIV';
        }

        if ($contact->isBlocked()) {
            $data['status'] = 'SPÄRRAD';
            $data['icon'] = Octicon::lock();
        }

        if ($contact->isBanned()) {
            $data['status'] = 'BANNLYST';
            $data['icon'] = Octicon::alert();
        }

        return $this->render('contact', $request, $env, ['contact' => $data]);
    }
}
