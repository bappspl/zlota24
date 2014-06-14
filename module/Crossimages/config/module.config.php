<?php
/**
 * 
 * @package Gallery
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Crossimages\Controller\Index' => 'Crossimages\Controller\IndexController'
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'crossimages' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/crossimages[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Crossimages\Controller\Index',
                        'action'     => 'index',                                              
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'crossimages' => __DIR__ . '/../view',
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