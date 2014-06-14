<?php    
namespace Gallery\Model;

class Gallery 
{
	public $id;
	public $name;
	public $price;
	public $description;
	public $image;

	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;                
		$this->name = (!empty($data['name'])) ? $data['name'] : null; 
		$this->price = (!empty($data['price'])) ? $data['price'] : null; 
		$this->description = (!empty($data['description'])) ? $data['description'] : null; 
		$this->image = (!empty($data['image'])) ? $data['image'] : null;  
    }
}