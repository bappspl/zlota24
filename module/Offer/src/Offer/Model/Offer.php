<?php    
namespace Offer\Model;

class Offer 
{
	public $id;	
	public $image;
	public $description_1;	
	public $description_2;
	public $description_3;	
	
	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;     
        $this->image = (!empty($data['image'])) ? $data['image'] : null;    
        $this->description_1 = (!empty($data['description_1'])) ? $data['description_1'] : null;
        $this->description_2 = (!empty($data['description_2'])) ? $data['description_2'] : null;
        $this->description_3 = (!empty($data['description_3'])) ? $data['description_3'] : null;
    }
}