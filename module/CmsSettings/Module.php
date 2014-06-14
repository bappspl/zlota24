<?php

namespace CmsSettings;

// for Acl
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use CmsSettings\Model\CmsSettings;
use CmsSettings\Model\CmsSettingsTable;
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
				'CmsSettings\Model\CmsSettingsTable' =>  function($sm) {
                     $tableGateway = $sm->get('CmsSettingsTableGateway');
                     $table = new CmsSettingsTable($tableGateway);
                     return $table;
                 },
				 'CmsSettingsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new CmsSettings());
                     return new TableGateway('cms_user', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
    }
 }