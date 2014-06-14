<?php

namespace Extra;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Extra\Model\Extra;
use Extra\Model\ExtraTable;

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
                'Extra\Model\ExtraTable' =>  function($sm) {
                    $tableGateway = $sm->get('ExtraTableGateway');
                    $table = new ExtraTable($tableGateway);
                    return $table;
                },
                 'ExtraTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Extra());
                    return new TableGateway('cms_additionalsection', $dbAdapter, null, $resultSetPrototype);
                },                                     
            ),
        );
    }      
}