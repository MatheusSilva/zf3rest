<?php
namespace Time;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\TimeController::class => InvokableFactory::class,
        ],
    ],

    /* no modulo de times vou ter que enviar o update via post 
     pois via put não é possivel fazer upload, esta forma e Rest e não Restfull pois só usa os metodos get e post e indica as açoes pela rota
    */
    'router' => [
        'routes' => [
            'time' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/time[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\TimeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'time' => __DIR__ . '/../view',
        ],
    ],
];