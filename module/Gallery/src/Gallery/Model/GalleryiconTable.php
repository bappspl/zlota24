<?php 
namespace Gallery\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use GalleryTable\Model\Expression;

class  GalleryiconTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function saveIconToGallery($idNewGallery, $icons) {
    	$tableIcons = explode(",", $icons);
        $tableIconsCount = count($tableIcons);
    	for($i=0; $i<$tableIconsCount; $i++) {
    		$data = array(
             'id_gallery' => $idNewGallery,
             'id_icon' => $tableIcons[$i]
            );
    		$this->tableGateway->insert($data);
    	}
    }
    public function saveEditIconToGallery($idGallery, $icons) {
        $this->tableGateway->delete('id_gallery = '. $idGallery);

        $tableIcons = explode(",", $icons);
        $tableIconsCount = count($tableIcons);
        for($i=0; $i<$tableIconsCount; $i++) {
            $data = array(
             'id_gallery' => $idGallery,
             'id_icon' => $tableIcons[$i]
            );
            $this->tableGateway->insert($data);
        }
    }
    public function getAllIconsById($id) {
        $result = $this->tableGateway->select(function(Select $select) use ($id){
                $select->join('cms_icon', 'id_icon = cms_icon.id', array('name'))
                       ->where('id_gallery = ' . $id);
            });
        return $result;


        $result = $this->tableGateway->select(array('id_gallery' => $id));
        return $result;
    }
    public function deleteAllIconByGalleryId($id)
    {
        $this->tableGateway->delete('id_gallery = '. $id);
    }
}