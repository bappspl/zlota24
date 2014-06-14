<?php
/**
 * 
 * @package Gallery
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Video\Controller\Index' => 'Video\Controller\IndexController'
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'video' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/video[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Video\Controller\Index',
                        'action'     => 'index',                                              
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'video' => __DIR__ . '/../view',
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
?>