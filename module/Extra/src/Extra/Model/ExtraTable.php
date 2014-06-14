<?php 
namespace Extra\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ExtraTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 

    public function addExtra(Extra $extra)
    {
    	$data = array(
            'image' => $extra->image,
            'description_1'  => $extra->description_1,            
        );	
        $this->tableGateway->update($data, array('id' => 1));
    }

    public function getById($id)
	{
		$rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
	}
}