<?php    
namespace Statute\Model;

class Statute 
{
	public $id;	
	public $description_1;		
	
	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;   
        $this->description_1 = (!empty($data['description_1'])) ? $data['description_1'] : null;
    }      
}