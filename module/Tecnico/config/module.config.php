<?php
namespace Tecnico;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'tecnico' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api/tecnico[/:id]',
                    'constraints' => [
                        'id'     => '[a-zA-Z0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\TecnicoController::class,
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'tecnico' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ],
    ],
];