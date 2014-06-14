<?php    
namespace Crossimages\Model;

class Crossimages
{
	public $id;
	public $first_row;
	public $second_row;
	public $image;

	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;                
		$this->first_row = (!empty($data['first_row'])) ? $data['first_row'] : null; 
		$this->second_row = (!empty($data['second_row'])) ? $data['second_row'] : null;  
		$this->image = (!empty($data['image'])) ? $data['image'] : null;  
    }
}