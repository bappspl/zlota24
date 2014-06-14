<?php

namespace Gallery;

// for Acl
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Gallery\Model\GalleryTable;
use Gallery\Model\GalleryiconTable;
use Gallery\Model\IconTable;
use Gallery\Model\Icon;
use Gallery\Model\Gallery;
use Gallery\Model\Galleryicon;
use Gallery\Model\PhotosTable;
use Gallery\Model\Photos;
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
				'Gallery\Model\GalleryTable' =>  function($sm) {
                     $tableGateway = $sm->get('GalleryTableGateway');
                     $table = new GalleryTable($tableGateway);
                     return $table;
                 },
				 'GalleryTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Gallery());
                     return new TableGateway('cms_gallery', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Gallery\Model\GalleryiconTable' =>  function($sm) {
                     $tableGateway = $sm->get('GalleryiconTableGateway');
                     $table = new GalleryiconTable($tableGateway);
                     return $table;
                 },
                 'GalleryiconTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Galleryicon());
                     return new TableGateway('cms_galleryicons', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Gallery\Model\IconTable' =>  function($sm) {
                     $tableGateway = $sm->get('IconTableGateway');
                     $table = new IconTable($tableGateway);
                     return $table;
                 },
                 'IconTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Icon());
                     return new TableGateway('cms_icon', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Gallery\Model\PhotosTable' =>  function($sm) {
                     $tableGateway = $sm->get('PhotosTableGateway');
                     $table = new PhotosTable($tableGateway);
                     return $table;
                 },
                 'PhotosTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Photos());
                     return new TableGateway('cms_photos', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
    }
 }