<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final class ExceptionLogger implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(LoggerInterface $logger, ResponseFactoryInterface $responseFactory)
    {
        $this->logger = $logger;
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Exception $e) {
            $this->logger->emergency(
                "Unhandled exception: {$e->getMessage()}",
                [
                    'class' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            return $this->responseFactory->createResponse(500, 'Internal Server Error');
        }
    }
}
