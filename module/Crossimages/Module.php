<?php

namespace Crossimages;

// for Acl
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Crossimages\Model\CrossimagesTable;
use Crossimages\Model\Crossimages;
class Module
 {
     public function getAutoloaderConfig()
     {
         return array(
	         'Zend\Loader\ClassMapAutoloader' => array(
	                 __DIR__ . '/autoload_classmap.php',
	             ),            
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }	
	 public function getServiceConfig()
    {
        return array(
             'factories' => array(
				'Crossimages\Model\CrossimagesTable' =>  function($sm) {
                     $tableGateway = $sm->get('CrossimagesTableGateway');
                     $table = new CrossimagesTable($tableGateway);
                     return $table;
                 },
				 'CrossimagesTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Crossimages());
                     return new TableGateway('cms_crossimage', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
    }
 }