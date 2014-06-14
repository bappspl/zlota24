<?php 
namespace Tags\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use TagsTable\Model\Expression;

class TagsTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function getAllTags() {
        $result = $this->tableGateway->select();
        return $result;
    }
    public function saveNewTag($tag) {
        $data = array(
            'name' => $tag
        );
        $this->tableGateway->insert($data);
        $id = $this->tableGateway->lastInsertValue;
        
        $i = $this->tableGateway->select();
        $count = $i->count();
        return array('id' => $id, 'i' => $count);
    }
    public function deleteTag($id)
    {
        $this->tableGateway->delete('id = '. $id);
    }

    public function saveEditTag($id, $name)
    {
        $data = array(
            'name' => $name
        );
        $this->tableGateway->update($data, "cms_tags.id = " . $id);
    }
}