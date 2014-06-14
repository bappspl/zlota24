<?php 
namespace Gallery\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use GalleryTable\Model\Expression;

class  GalleryTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function getAllGalleries()
    {
        $result = $this->tableGateway->select();
        return $result;
    }
    public function getAllGalleriesName()
    {
        $result = $this->tableGateway->select(function(Select $select){
            $select->columns(array('id','name'));                   
        });
        return $result;
    }
    public function getAllDataById($id)
    {
        $result = $this->tableGateway->select(array('id' => $id));
        $row = $result->current();
        return $row;
    }
    public function saveGalleryInfo($name, $price, $description) {
		$data = array(
            'name' => $name,
            'price' => $price,
            'description' => $description
        );
		$this->tableGateway->insert($data);
		$id = $this->tableGateway->lastInsertValue;
		return $id;
    }
    public function saveEditGalleryInfo($id, $name, $price, $description) {
        $data = array(
            'name' => $name,
            'price' => $price,
            'description' => $description
        );
        $this->tableGateway->update($data, "cms_gallery.id = " . $id);
    }
    public function saveGalleryThumb($id, $image) {
    	$data = array(
             'image' => $image
         );
		 $this->tableGateway->update($data, "cms_gallery.id = " . $id);
    }
    public function deleteGalleryById($id)
    {
        $this->tableGateway->delete('id = '. $id);
    }
}