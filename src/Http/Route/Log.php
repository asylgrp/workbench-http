<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use inroutephp\inroute\Annotations\GET;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Log extends AbstractRoute
{
    private string $logFile;

    public function __construct(string $logFile)
    {
        $this->logFile = $logFile;
    }

    /**
     * @GET(path="/log", name="log")
     */
    public function list(ServerRequestInterface $request, EnvironmentInterface $env): ResponseInterface
    {
        return $this->render(
            'log',
            $request,
            $env,
            ['log' => file_get_contents($this->logFile)]
        );
    }
}
