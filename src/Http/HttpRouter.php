<?php 

declare(strict_types = 1);

namespace workbench\webb\Http;

/**
 * NOTE: This file was auto-generated by inroute 1.1.1 and should not be edited directly.
 */
final class HttpRouter implements \inroutephp\inroute\Runtime\HttpRouterInterface
{
    use \inroutephp\inroute\Runtime\Aura\HttpRouterTrait;

    protected function loadRoutes(\Aura\Router\Map $map): void
    {
        \inroutephp\inroute\Package::validateVersion('1.1.1');

        $mapper = new \inroutephp\inroute\Runtime\Aura\RouteMapper($map);

$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'sign-out',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/sign-out',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\SignOut',
            ],
            'serviceMethod' => [
                'signOut',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'contact',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/contacts/{id}',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\ContactRead',
            ],
            'serviceMethod' => [
                'get',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'decisions',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/decisions',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Decisions',
            ],
            'serviceMethod' => [
                'list',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'workbench\\webb\\Http\\Route\\Decisions:create',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'POST',
                ],
            ],
            'path' => [
                '/decisions',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Decisions',
            ],
            'serviceMethod' => [
                'create',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'decision',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/decisions/{id}',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Decisions',
            ],
            'serviceMethod' => [
                'get',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'new-contact-form',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/forms/new-contact',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\ContactCreate',
            ],
            'serviceMethod' => [
                'get',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'workbench\\webb\\Http\\Route\\ContactCreate:post',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'POST',
                ],
            ],
            'path' => [
                '/contacts',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\ContactCreate',
            ],
            'serviceMethod' => [
                'post',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'claims',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/claims',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Claims',
            ],
            'serviceMethod' => [
                'list',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'new-claim-form',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/forms/new-claim',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Claims',
            ],
            'serviceMethod' => [
                'newForm',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'workbench\\webb\\Http\\Route\\Claims:createNew',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'POST',
                ],
            ],
            'path' => [
                '/claims',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Claims',
            ],
            'serviceMethod' => [
                'createNew',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'claim',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/claims/{id}',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Claims',
            ],
            'serviceMethod' => [
                'get',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'claim-delete',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'POST',
                ],
            ],
            'path' => [
                '/claims/{id}/delete',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Claims',
            ],
            'serviceMethod' => [
                'delete',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'clear-claims',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'POST',
                ],
            ],
            'path' => [
                '/clear-claims',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Claims',
            ],
            'serviceMethod' => [
                'purge',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'contacts',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/contacts',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Contacts',
            ],
            'serviceMethod' => [
                'get',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'trimmings.js',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/trimmings.js',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Resources',
            ],
            'serviceMethod' => [
                'trimmings',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'bootstrap.css',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/bootstrap.css',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Resources',
            ],
            'serviceMethod' => [
                'bootstrap',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'edit-contact-form',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/forms/edit-contact/{id}',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\ContactUpdate',
            ],
            'serviceMethod' => [
                'get',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'workbench\\webb\\Http\\Route\\ContactUpdate:post',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'POST',
                ],
            ],
            'path' => [
                '/contacts/{id}',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\ContactUpdate',
            ],
            'serviceMethod' => [
                'post',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'billboard',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Billboard',
            ],
            'serviceMethod' => [
                'get',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'workbench\\webb\\Http\\Route\\Billboard:post',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'POST',
                ],
            ],
            'path' => [
                '/',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Billboard',
            ],
            'serviceMethod' => [
                'post',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'log',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'GET',
                ],
            ],
            'path' => [
                '/log',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\Log',
            ],
            'serviceMethod' => [
                'list',
            ],
        ],
    ],
    $o[0],
    []
));
$mapper->mapRoute(\Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['inroutephp\\inroute\\Runtime\\Route'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('inroutephp\\inroute\\Runtime\\Route')),
    ],
    null,
    [
        'inroutephp\\inroute\\Runtime\\Route' => [
            'name' => [
                'contact-delete',
            ],
            'routable' => [
                true,
            ],
            'httpMethods' => [
                [
                    'POST',
                ],
            ],
            'path' => [
                '/contacts/{id}/delete',
            ],
            'serviceId' => [
                'workbench\\webb\\Http\\Route\\ContactDelete',
            ],
            'serviceMethod' => [
                'post',
            ],
        ],
    ],
    $o[0],
    []
));
    }
}
