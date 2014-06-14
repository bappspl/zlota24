<?php

namespace Tags;

// for Acl
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Tags\Model\TagsTable;
use Tags\Model\Tags;
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
				'Tags\Model\TagsTable' =>  function($sm) {
                     $tableGateway = $sm->get('TagsTableGateway');
                     $table = new TagsTable($tableGateway);
                     return $table;
                 },
				 'TagsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Tags());
                     return new TableGateway('cms_tags', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
    }
 }