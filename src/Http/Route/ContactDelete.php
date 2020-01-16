<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\CommandBus\DeleteContactPerson;
use workbench\webb\DependencyInjection\CommandBusProperty;
use workbench\webb\Utils\Validators;
use inroutephp\inroute\Annotations\POST;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ContactDelete extends AbstractRoute
{
    use CommandBusProperty;

    /**
     * @POST(path="/contacts/{id}/delete", name="contact-delete")
     */
    public function post(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        $id = Validators::idValidator()->validate($request->getAttribute('id'));

        // TODO fetch contact person
        $contact = null;

        $this->commandBus->handle(new DeleteContactPerson($contact));

        return $this->redirect(
            $env->getUrlGenerator()->generateUrl('contacts'),
            $contact->getName() . ' raderades'
        );
    }
}
