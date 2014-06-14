<?php
/**
 * 
 * @package Gallery
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Gallery\Controller\Index' => 'Gallery\Controller\IndexController'
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'gallery' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/gallery[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Gallery\Controller\Index',
                        'action'     => 'index',                                              
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'gallery' => __DIR__ . '/../view',
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