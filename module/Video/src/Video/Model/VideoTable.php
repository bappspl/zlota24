<?php 
namespace Video\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use VideoTable\Model\Expression;

class VideoTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function getVideoData() {
        $result = $this->tableGateway->select(array('id' => 1));
        $row = $result->current();
        return $row;
    }
    public function saveEditVideo($id, $link, $description) {
        $data = array(
            'link' => $link,
            'description' => $description
        );
        $this->tableGateway->update($data, "cms_video.id = " . $id);
    }
}