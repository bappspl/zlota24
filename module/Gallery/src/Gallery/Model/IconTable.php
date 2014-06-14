<?php 
namespace Gallery\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use GalleryTable\Model\Expression;

class  IconTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function getAllIcons() {
    	$result = $this->tableGateway->select();
		return $result;
    }
}