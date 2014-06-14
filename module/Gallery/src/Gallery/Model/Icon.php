<?php    
namespace Gallery\Model;

class Icon 
{
	public $id;
	public $name;
	public $image;

	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;                
		$this->name = (!empty($data['name'])) ? $data['name'] : null; 
		$this->image = (!empty($data['image'])) ? $data['image'] : null;  
    }
}