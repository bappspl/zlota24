<?php 
namespace Gallery\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use GalleryTable\Model\Expression;

class  PhotosTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function saveImageToGallery($idGallery, $wynik) {
		$data = array(
            'id_gallery' => $idGallery,
            'name' => '',
            'image' => $wynik
        );
		$this->tableGateway->insert($data);
    }
    public function saveEditImageToGallery($idGallery, $wynik) {
        $data = array(
            'id_gallery' => $idGallery,
            'name' => '',
            'image' => $wynik
        );
        $this->tableGateway->insert($data);
        $id = $this->tableGateway->lastInsertValue;
        return $id;
    }
    public function getAllPhotosById($id) {
        $result = $this->tableGateway->select(array('id_gallery' => $id));
        return $result;
    }
    public function deletePhotoById($id)
    {
        $this->tableGateway->delete('id = '. $id);
    }
    public function deleteAllPhotosByGalleryId($id)
    {
        $this->tableGateway->delete('id_gallery = '. $id);
    }
}