<?php
/**
 * 
 * @package Gallery
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Tags\Controller\Index' => 'Tags\Controller\IndexController'
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'tags' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/tags[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Tags\Controller\Index',
                        'action'     => 'index',                                              
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'tags' => __DIR__ . '/../view',
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