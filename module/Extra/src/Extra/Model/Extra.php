<?php    
namespace Extra\Model;

class Extra 
{
	public $id;	
	public $image;
	public $description_1;		
	
	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;     
        $this->image = (!empty($data['image'])) ? $data['image'] : null;    
        $this->description_1 = (!empty($data['description_1'])) ? $data['description_1'] : null;
    }      
}