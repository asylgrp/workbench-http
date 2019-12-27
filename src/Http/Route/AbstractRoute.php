<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\DependencyInjection\MustacheProperty;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

abstract class AbstractRoute
{
    use MustacheProperty;

    /**
     * @param array<string, mixed> $data
     */
    protected function render(string $templateName, array $data = []): ResponseInterface
    {
        return new HtmlResponse($this->mustache->render($templateName, $data));
    }
}
