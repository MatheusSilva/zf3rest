<?php
namespace Divisao;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'divisao' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api/divisao[/:id]',
                    'constraints' => [
                        'id'     => '[a-zA-Z0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\DivisaoController::class,
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'divisao' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ],
    ],
];