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
//-                'user' => array(
//-                    'login' => 'guest',
//-                    'all'   => 'player'
//-                )
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
				// 'Auth\Controller\Registration' => array(
				// 	'all'	=> 'guest',				
				// ),
				// 'Auth\Controller\Index' => array(
				// 	'all'	=> 'guest',				
				// ),
				// 'Application\Controller\Index' => array(
				// 	'all'	=> 'guest',	
 			// 	),
 			// 	'Match\Controller\Index' => array(
				// 	'all'	=> 'player',	
 			// 	),
    //             'Player\Controller\Index' => array(
    //                 'all'   => 'guest',    
    //             ),
				// 'Messages\Controller\Index' => array(
    //                 'all'   => 'guest',    
    //             ),
    //             'Training\Controller\Index' => array(
    //                 'all'   => 'guest',    
    //             ),
// 				'CsnUser\Controller\UserDoctrine' => array(
// 					'all'	=> 'guest'
// 				),
// 				'CsnUser\Controller\UserDoctrineSimpleAuthorizationAcl' => array(
// //					'all'   => 'guest',
// 					'index'	=> 'guest',
// 					'create' => 'player'
// 				),
// 				'CsnUser\Controller\UserDoctrinePureAcl' => array(
// 					'all'   => 'player',
// 				),
// 				'Application\Controller\Index' => array(
// 					'all'   => 'guest'					
// 				),
// 				'Auth\Controller\Index' => array(
// 					// 'index' => 'guest',
//                     // 'all'   => 'player',	
// 					'all'   => 'guest'					
// 				),
// 				'zfcuser' => array( // zg-commoms ZfcUser
// 					// 'index' => 'guest',
//                     // 'all'   => 'player',
// 					'all'   => 'guest'					
// 				),
// 				'Auth\Controller\Hello' => array(
// 					'all'   => 'guest'					
// 				),
// 				'Auth\Controller\FormTests' => array(
// 					'all'   => 'guest'					
// 				),
// 				'AuthDoctrine\Controller\Index' => array(
// 					'all'   => 'guest'
// 					// 'all'   => 'player',					
// 				),
// 				'AuthDoctrine\Controller\Registration' => array(
// 					'all' => 'guest'
// 				),
// 				'CsnCms\Controller\Index' => array(
// 					// 'all'   => 'guest'
// 					'view'	=> 'guest',
// 					'index' => 'moderator',
// 					'add'	=> 'moderator',
// 					'edit'  => 'moderator',	
// 					'delete'=> 'moderator',						
// 				),
// 				'CsnCms\Controller\Translation' => array(
// 					// 'all'   => 'guest'
// 					'view'	=> 'guest',
// 					'index' => 'moderator',
// 					'add'	=> 'moderator',
// 					'edit'  => 'moderator',	
// 					'delete'=> 'moderator',						
// 				),
// 				'CsnCms\Controller\Comment' => array(
// 					// 'all'   => 'guest'
// 					'view'	=> 'guest',
// 					'index' => 'moderator',
// 					'add'	=> 'moderator',
// 					'edit'  => 'moderator',	
// 					'delete'=> 'moderator',						
// 				),
// 				'AuthDoctrine\Controller\moderator' => array(
// 					'all'	=> 'moderator',
// 				),
// 				'CsnFileManager\Controller\Index' => array(
// 					'all'	=> 'player',
// 				),				
// 				// for CMS articles
// 				'Public Resource' => array(
// 					'view'	=> 'guest',					
// 				),
// 				'Private Resource' => array(
// 					'view'	=> 'player',					
// 				),
// 				'moderator Resource' => array(
// 					'view'	=> 'moderator',					
// 				),
            )
        )
    )
);
