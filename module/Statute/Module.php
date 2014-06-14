<?php

namespace Statute;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Statute\Model\Statute;
use Statute\Model\StatuteTable;

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
                'Statute\Model\StatuteTable' =>  function($sm) {
                    $tableGateway = $sm->get('StatuteTableGateway');
                    $table = new StatuteTable($tableGateway);
                    return $table;
                },
                 'StatuteTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Statute());
                    return new TableGateway('cms_statute', $dbAdapter, null, $resultSetPrototype);
                },                                     
            ),
        );
    }      
}