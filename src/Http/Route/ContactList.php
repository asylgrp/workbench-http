<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\DependencyInjection;
use inroutephp\inroute\Annotations\BasePath;
use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @BasePath(path="/contacts")
 */
final class ContactList extends AbstractRoute
{
    use DependencyInjection\ContactPersonRepositoryProperty;

    /**
     * @GET(path="/active")
     */
    public function listActive(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render(
            'contact-list',
            [
                'desc' => 'Aktiva',
                'contacts' => $this->contactPersonRepository->activeContactPersons()
            ]
        );
    }

    /**
     * @GET(path="/banned")
     */
    public function listBanned(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render(
            'contact-list',
            [
                'desc' => 'Spärrade',
                'contacts' => $this->contactPersonRepository->bannedContactPersons()
            ]
        );
    }

    /**
     * @GET(path="/blocked")
     */
    public function listBlocked(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render(
            'contact-list',
            [
                'desc' => 'Blockerade',
                'contacts' => $this->contactPersonRepository->blockedContactPersons()
            ]
        );
    }
}
