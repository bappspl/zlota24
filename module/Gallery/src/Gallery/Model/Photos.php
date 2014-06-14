<?php    
namespace Gallery\Model;

class Photos
{
	public $id;
	public $id_gallery;
	public $name;
	public $image;

	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;                
		$this->id_gallery = (!empty($data['id_gallery'])) ? $data['id_gallery'] : null; 
		$this->name = (!empty($data['name'])) ? $data['name'] : null;  
		$this->image = (!empty($data['image'])) ? $data['image'] : null; 
    }
}