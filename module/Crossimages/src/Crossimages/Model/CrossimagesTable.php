<?php 
namespace Crossimages\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use CrossimagesTable\Model\Expression;

class  CrossimagesTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function getAllCrossimages() {
        $result = $this->tableGateway->select();
        return $result;
    }
    public function getCrossimagesById($id) {
        $result = $this->tableGateway->select(array('id' => $id));
        $row = $result->current();
        return $row;
    }
    public function saveEditCrossimages($id, $fristRow, $secondRow) {
        $data = array(
            'first_row' => $fristRow,
            'second_row' => $secondRow
        );
        $this->tableGateway->update($data, "cms_crossimage.id = " . $id);
    }
}