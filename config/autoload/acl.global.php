<?php
// http://p0l0.binware.org/index.php/2012/02/18/zend-framework-2-authentication-acl-using-eventmanager/
// First I created an extra config for ACL (could be also in module.config.php, but I prefer to have it in a separated file)
return array(
    'acl' => array(
        'roles' => array(
            'guest'   => null,            
            'admin'  => 'guest',
        ),
        'resources' => array(
            'allow' => array(

				'Auth\Controller\Index' => array(
					'all'	=> 'guest',				
				),
                'Auth\Controller\Admin' => array(
                    'all'   => 'admin',             
                ),
				'Gallery\Controller\Index' => array(
                    'all'   => 'admin',             
                ),	
                'Crossimages\Controller\Index' => array(
                    'all'   => 'admin',             
                ),			
                'Auth\Controller\Registration' => array(
                    'all'   => 'guest',             
                ),
                'Offer\Controller\Index' => array(
                    'all'   => 'admin',             
                ),
                'Video\Controller\Index' => array(
                    'all'   => 'admin',             
                ),
                'Tags\Controller\Index' => array(
                    'all'   => 'admin',             
                ),
                'Extra\Controller\Index' => array(
                    'all'   => 'admin',             
                ),
                'CmsSettings\Controller\Index' => array(
                    'all'   => 'admin',             
                ),
                'Application\Controller\Index' => array(
                    'all'   => 'guest',             
                ),
                'Statute\Controller\Index' => array(
                    'all'   => 'admin',             
                ),				
            )
        )
    )
);
