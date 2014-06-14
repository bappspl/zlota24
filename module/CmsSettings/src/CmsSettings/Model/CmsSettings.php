<?php    
namespace CmsSettings\Model;

class CmsSettings
{
	//pms_user
	public $id;
	public $login;
	public $email;
	public $password;
	public $password_salt;
	
	public function exchangeArray($data)
    {
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;                
		$this->email = (!empty($data['email'])) ? $data['email'] : null; 
		$this->login = (!empty($data['login'])) ? $data['login'] : null; 
		$this->password_salt = (!empty($data['password_salt'])) ? $data['password_salt'] : null;
    }
}