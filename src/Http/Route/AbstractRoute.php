<?php

declare(strict_types = 1);

namespace workbench\webb\Http\Route;

use workbench\webb\Utils\Validators;
use inroutephp\inroute\Runtime\EnvironmentInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Mustache_Engine;
use Octicons\Octicon;

abstract class AbstractRoute
{
    private Mustache_Engine $mustache;

    /**
     * @required
     */
    public function setMustacheEngine(Mustache_Engine $mustache): void
    {
        $this->mustache = $mustache;
    }

    protected function redirect(string $url, string $msg = '', string $error = ''): ResponseInterface
    {
        $query = [];

        if ($msg) {
            $query[] = 'msg="' . base64_encode($msg) . '"';
        }

        if ($error) {
            $query[] = 'error="' . base64_encode($error) . '"';
        }

        if ($query) {
            $url .= '?' . implode('&', $query);
        }

        return (new EmptyResponse(303))->withHeader('Location', $url);
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function render(
        string $templateName,
        ServerRequestInterface $request,
        EnvironmentInterface $env,
        array $data = []
    ): ResponseInterface {
        $data['alert:error'] ??= [];

        if (isset($request->getQueryParams()['error'])) {
            $data['alert:error'][] = Validators::textValidator()->validate(
                base64_decode($request->getQueryParams()['error'])
            );
        }

        $data['alert:success'] ??= [];

        if (isset($request->getQueryParams()['msg'])) {
            $data['alert:success'][] = Validators::textValidator()->validate(
                base64_decode($request->getQueryParams()['msg'])
            );
        }

        $data['links'] = [
            'billboard' => [
                'icon' => '',
                'href' => $env->getUrlGenerator()->generateUrl('billboard'),
            ],
            'contacts' => [
                'icon' => Octicon::organization(),
                'href' => $env->getUrlGenerator()->generateUrl('contacts'),
            ],
            'claims' => [
                'icon' => Octicon::tasklist(),
                'href' => $env->getUrlGenerator()->generateUrl('claims'),
            ],
            'decisions' => [
                'icon' => Octicon::database(),
                'href' => $env->getUrlGenerator()->generateUrl('decisions'),
            ],
            'log' => [
                'icon' => Octicon::history(),
                'href' => $env->getUrlGenerator()->generateUrl('log'),
            ],
            'sign-out' => [
                'icon' => Octicon::sign_out(),
                'href' => $env->getUrlGenerator()->generateUrl('sign-out'),
            ],
            'new-contact-form' => [
                'icon' => '',
                'href' => $env->getUrlGenerator()->generateUrl('new-contact-form'),
            ],
            'new-claim-form' => [
                'icon' => '',
                'href' => $env->getUrlGenerator()->generateUrl('new-claim-form'),
            ],
            'trimmings_js' => [
                'icon' => '',
                'href' => $env->getUrlGenerator()->generateUrl('trimmings.js'),
            ],
            'bootstrap_css' => [
                'icon' => '',
                'href' => $env->getUrlGenerator()->generateUrl('bootstrap.css'),
            ],
        ];

        return new HtmlResponse($this->mustache->render($templateName, $data));
    }
}
