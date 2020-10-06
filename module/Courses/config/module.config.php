<?php

namespace Courses;


use Laminas\Router\Http\Segment;


return [
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'courselist' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/courses/courselist[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CourselistController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'jposition' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/courses/jposition[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\JpositionController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'contact' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/courses/contact[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    

    'view_manager' => [
        'template_path_stack' => [
            'courselist' => __DIR__ . '/../view',
            'jposition' => __DIR__ . '/../view',
            'contact' => __DIR__ . '/../view',
            
        ],
    ],
];

?>