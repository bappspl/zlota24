<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace CmsSettings\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Model\Auth;
use CmsSettings\Model;
use CmsSettings\Model\CmsSettings;
use CmsSettings\Form\CmsSettingsForm;
use Zend\Authentication\AuthenticationService;

use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

class IndexController extends AbstractActionController
{
	protected $cmssettingsTable;
	public function getCmsSettingsTable()
	{
		if (!$this->cmssettingsTable) {
			$sm = $this->getServiceLocator();
			$this->cmssettingsTable = $sm->get('CmsSettings\Model\CmsSettingsTable');
		} 
		return $this->cmssettingsTable;
	}
    public function indexAction()
    {
    	$this->layout('layout/layout-cmssettings');
    	$auth = new AuthenticationService();
         if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();
			return new ViewModel();
		} else {
			return $this->redirect()->toUrl('/');
		}
    }
	
	// zmiana hasła
	public function checkpasswordajaxAction()
	{
		$request = $this->getRequest();
		$auth = new AuthenticationService();
		$user = $auth->getIdentity();		
        $login = $user->login;
			 if ($request->isPost()) {
				$data = $request->getPost();
				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');				
				$config = $this->getServiceLocator()->get('Config');
				$staticSalt = $config['static_salt'];
				$authAdapter = new AuthAdapter($dbAdapter,
										   'cms_user', 
										   'login', 
										   'password', 
										   "MD5(CONCAT('$staticSalt', ?, password_salt))"
										  );
				$authAdapter
					->setIdentity($login)
					->setCredential($data['password'])	
				;			
				$result = $auth->authenticate($authAdapter);	
				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						$tablica['wynik'] = 'failed';
						break;
					case Result::FAILURE_CREDENTIAL_INVALID:
						$tablica['wynik'] = 'failed';						
						break;
					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'password'
						));						
						$tablica['wynik'] = 'succes';
						break;
					default:
						$tablica['wynik'] = 'failed';
						break;
				}
				echo json_encode($tablica);
			}
		return $this->response;
	}

	public function saveUserAjaxAction()
    {
    	$request = $this->getRequest();
        if ($request->isPost()) {
        	$data = $request->getPost();
        	$auth = new AuthenticationService();
			$user = $auth->getIdentity();        	
        	$id = $user->id;        	
        	$data = $this->prepareData($data);							
			$this->getCmsSettingsTable()->saveUser($id, $data);
			$tablica['wynik'] = 'succes';
           	echo json_encode($tablica);           	
		}
		return $this->response;
    }

    public function prepareData($data)
	{		
		$data['password_salt'] = $this->generateDynamicSalt();				
		$data['password'] = $this->encriptPassword(
			$this->getStaticSalt(), 
			$data['password'], 
			$data['password_salt']
		);					
		return $data;
	}

	public function generateDynamicSalt()
    {
		$dynamicSalt = '';
		for ($i = 0; $i < 50; $i++) {
			$dynamicSalt .= chr(rand(33, 126));
		}
        return $dynamicSalt;
    }
	
    public function getStaticSalt()
    {
		$staticSalt = '';
		$config = $this->getServiceLocator()->get('Config');
		$staticSalt = $config['static_salt'];		
        return $staticSalt;
    }

    public function encriptPassword($staticSalt, $password, $dynamicSalt)
    {
		return $password = md5($staticSalt . $password . $dynamicSalt);
    }
}
