<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\DependencyInjection\ContactPersonRepositoryProperty;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Octicons\Octicon;

final class Contacts extends AbstractRoute
{
    use ContactPersonRepositoryProperty;

    /**
     * @GET(path="/contacts", name="contacts")
     */
    public function get(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $contacts = [];

        foreach ($this->contactPersonRepository->contactPersons() as $contact) {
            $css = [];
            $icon = '';

            if ($contact->isActive()) {
                $css[] = 'wb-active';
            }

            if ($contact->isBlocked()) {
                $css[] = 'table-secondary';
                $css[] = 'wb-blocked';
                $icon = Octicon::lock();
            }

            if ($contact->isBanned()) {
                $css[] = 'table-danger';
                $css[] = 'wb-banned';
                $icon = Octicon::alert();
            }

            $contacts[] = [
                'css' => implode(' ', $css),
                'icon' => $icon,
                'name' => $contact->getName(),
                'link' => $env->getUrlGenerator()->generateUrl('contact', ['id' => $contact->getId()]),
                'account' => $contact->getAccount(),
                'mail' => $contact->getMail(),
                'phone' => $contact->getPhone(),
                'comment' => $contact->getComment(),
            ];
        }

        return $this->render('contact-list', $request, $env, ['contacts' => $contacts]);
    }
}
