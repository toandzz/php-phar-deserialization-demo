<?php

use Application\Controller\IndexController;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'upload' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/upload',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'upload',
                    ],
                ],
            ],
            'resize' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/resize',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'resize',
                    ],
                ],
            ],
            'download' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/download',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'download',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => function ($container) {
                return new IndexController();
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
