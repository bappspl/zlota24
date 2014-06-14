<?php
namespace Auth\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

	public function getUserByToken($token)
    {
        $rowset = $this->tableGateway->select(array('registration_token' => $token));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $token");
        }
        return $row;
    }
	
    public function activateUser($id)
    {
		$data['active'] = 1;
		$data['email_confirmed'] = 1;
		$this->tableGateway->update($data, array('id' => (int)$id));
    }	

    public function getUserByEmail($email)
    {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $email");
        }
        return $row;
    }

    public function changePassword($id, $password)
    {
		$data['password'] = $password;
		$this->tableGateway->update($data, array('id' => (int)$id));
    }
	
    public function saveUser(Auth $auth)
    {
		// for Zend\Db\TableGateway\TableGateway we need the data in array not object
        $data = array(
            'login' 				=> $auth->login,
            'password'  		    => $auth->password,
            'email'  			    => $auth->email,
            // 'usrl_id'  				=> $auth->usrl_id,
            // 'lng_id'  				=> $auth->lng_id,
            'active'  		    	=> $auth->active,
            // 'usr_question'  		=> $auth->usr_question,
            // 'usr_answer'  			=> $auth->usr_answer,
            // 'usr_picture'  			=> $auth->usr_picture,
            'password_salt' 	    => $auth->password_salt,
            'registration_date'     => $auth->registration_date,
            'registration_token'    => $auth->registration_token,
			'email_confirmed'	    => $auth->email_confirmed,
        );
		// If there is a method getArrayCopy() defined in Auth you can simply call it.
		// $data = $auth->getArrayCopy();

        $id = (int)$auth->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form $id does not exist');
            }
        }
    }
	
    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }	

    public function cronTest()
    {
        $data = array(
            'login' =>  'cronchujudzialaj1idzik2'
            );
        $this->tableGateway->insert($data);
    }

    public function findLogin($login)
    {
        $rowset = $this->tableGateway->select(array('login' => $login));
        $row = $rowset->current();
        if (!$row) {
            return true;
        } else {
            return false;
        }
    }

    public function findEmail($email)
    {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        if (!$row) {
            return true;
        } else {
            return false;
        }
    }
	
	public function autoLogout($id)
    {
		$data = array('online' => 0);
		$this->tableGateway->update($data, array('id' => $id));
    }
	public function autoLogin($id)
    {
		$data = array('online' => 1);
		$this->tableGateway->update($data, array('id' => $id));
    }
}