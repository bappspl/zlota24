<?php 
namespace CmsSettings\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use CmsSettings\Model\Expression;

class  CmsSettingsTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

	public function saveUser($id, $data)
	{     
		$data = array(
			'password' 				=> $data['password'],
			'password_salt' 	    => $data['password_salt'],          
		);   
        $this->tableGateway->update($data, array('id' => $id));           
    }
}