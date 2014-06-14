<?php    
namespace Video\Model;

class Video
{
	public $id;
	public $link;
	public $description;

	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;                
		$this->link = (!empty($data['link'])) ? $data['link'] : null; 
		$this->description = (!empty($data['description'])) ? $data['description'] : null;  
    }
}