<?php    
namespace Gallery\Model;

class Galleryicon 
{
	public $id;
	public $id_gallery;
	public $id_icon;

	public $name;
	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;                
		$this->id_gallery = (!empty($data['id_gallery'])) ? $data['id_gallery'] : null;
		$this->id_icon = (!empty($data['id_icon'])) ? $data['id_icon'] : null; 

		$this->name = (!empty($data['name'])) ? $data['name'] : null; 
    }
}