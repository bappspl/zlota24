<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Statute\Controller\Index' => 'Statute\Controller\IndexController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'statute' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/statute[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Statute\Controller\Index',
                        'action'     => 'index',                                              
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'statute' => __DIR__ . '/../view',
        ),
         'strategies' => array(
            'ViewJsonStrategy',
        ),  
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
    ), 
);

