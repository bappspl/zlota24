<?php
/**
 * 
 * @package Profile
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'CmsSettings\Controller\Index' => 'CmsSettings\Controller\IndexController'
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'cmssettings' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/cmssettings[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CmsSettings\Controller\Index',
                        'action'     => 'index',                                              
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'cmssettings' => __DIR__ . '/../view',
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