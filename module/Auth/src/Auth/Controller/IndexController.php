<?php
namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use Auth\Model\Auth;
use Auth\Form\AuthForm;

use Zend\View\Model\JsonModel;

use Zend\Mail\Message;

use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class IndexController extends AbstractActionController
{
	protected $usersTable;	
	
    public function indexAction()
    {
		return new ViewModel();
	}	
	
    public function loginAction()
	{
		
		$this->layout('layout/layout.phtml');
		$user = $this->identity();
		$form = new AuthForm();		
		$messages = null;

		$request = $this->getRequest();
        if ($request->isPost()) {
			$authFormFilters = new Auth();
            	
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
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
					->setIdentity($data['login'])
					->setCredential($data['password'])
				;
				
				$auth = new AuthenticationService();
				
				$result = $auth->authenticate($authAdapter);			
				
				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						// do stuff for nonexistent identity
						break;

					case Result::FAILURE_CREDENTIAL_INVALID:
						// do stuff for invalid credential
						break;

					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'password'
						));
						$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
//						if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session
						if ($data['rememberme']) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe($time);
						}
						return $this->redirect()->toUrl('/settings');
						break;

					default:
						// do stuff for other failure
						break;
				}				
				foreach ($result->getMessages() as $message) {
					$messages .= "$message\n"; 
				}			
			 }
		}
		return new ViewModel(array('form' => $form, 'messages' => $messages));
	}
	public function autoLogoutAjaxAction()
	{
		$auth = new AuthenticationService();
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			$this->getUsersTable()->autoLogout($identity->id);
		}
		return $this->response;
	}
	public function autoLoginAjaxAction()
	{
		$auth = new AuthenticationService();
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			$this->getUsersTable()->autoLogin($identity->id);
		}
		return $this->response;
	}
	public function logoutAction()
	{
		$auth = new AuthenticationService();
		// or prepare in the globa.config.php and get it from there
		// $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}			
		
		$auth->clearIdentity();
//		$auth->getStorage()->session->getManager()->forgetMe(); // no way to get the sessionmanager from storage
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();
		
		//return $this->redirect()->toRoute('auth/default', array('controller' => 'index', 'action' => 'login'));		
		return $this->redirect()->toRoute('home');	
	}	

	public function checkloginajaxAction()
	{
		$request = $this->getRequest();
			 if ($request->isPost()) {
				$data = $request->getPost();
				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
				$config = $this->getServiceLocator()->get('Config');
				$staticSalt = $config['static_salt'];

				$authAdapter = new AuthAdapter($dbAdapter,
										   'cms_user', // there is a method setTableName to do the same
										   'login', // there is a method setIdentityColumn to do the same
										   'password', // there is a method setCredentialColumn to do the same
										   "MD5(CONCAT('$staticSalt', ?, password_salt))" // setCredentialTreatment(parametrized string) 'MD5(?)'
										  );
				$authAdapter
					->setIdentity($data['login'])
					->setCredential($data['password'])
				;
				
				$auth = new AuthenticationService();
				// or prepare in the globa.config.php and get it from there. Better to be in a module, so we can replace in another module.
				// $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
				// $sm->setService('Zend\Authentication\AuthenticationService', $auth); // You can set the service here but will be loaded only if this action called.
				$result = $auth->authenticate($authAdapter);			
				
				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						// do stuff for nonexistent identity
						$tablica['wynik'] = 'failed';
						break;

					case Result::FAILURE_CREDENTIAL_INVALID:
						$tablica['wynik'] = 'failed';
						// do stuff for invalid credential
						break;

					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'password'
						));
						$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
	//						if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session
						if ($data['rememberme']) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe($time);
						}
						$tablica['wynik'] = 'success';
						break;

					default:
						$tablica['wynik'] = 'failed';
						// do stuff for other failure
						break;
				}
				$result = new JsonModel(array(
                    'wynik' => $tablica['wynik']                                       
	            ));
	           return $result;

			}
			return $this->response;
	}

	public function checkIfLoginExistsAjaxAction()
	{
		$request = $this->getRequest();
    	if ($request->isPost()){
    		//$login = $this->params('login');  
    		$login = $this->getRequest()->getPost('login');	
    		$login = trim($login);	
    		$getLogin = $this->getUsersTable()->findLogin($login);
    		if ($getLogin) {
    			$tablica['wynik'] = 'succes';
           		echo json_encode($tablica);
    		} else {
    			$tablica['wynik'] = 'failed';
           		echo json_encode($tablica);
    		}    		
    	}
    	return $this->response;
	}	

	public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Auth\Model\UsersTable');
        }
        return $this->usersTable;
    }

    public function sendMailAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost()){ 
    		if (rpHash($_POST['defaultReal']) == $_POST['defaultRealHash']) {   		  
	    		$name = $this->getRequest()->getPost('name');
	    		$mail = $this->getRequest()->getPost('mail');	
	    		$phone = $this->getRequest()->getPost('phone');
	    		$text = $this->getRequest()->getPost('text');

	    	
	    			$body = "Od: " . $name
			 			 . '<br> Mail: ' . $mail .
			 			' <br> Telefon: ' .
			 			$phone . '<br> Wiadomość: ' . $text;
			    $htmlPart = new MimePart($body);
			    $htmlPart->type = "text/html";
			    $htmlPart->charset = "UTF-8";

			    $textPart = new MimePart($body);
			    $textPart->type = "text/plain";

			    $body = new MimeMessage();
			    $body->setParts(array($textPart, $htmlPart));

			    $message = new Message();
			    $message->setFrom('vmadmin@vmadmin.vdl.pl', 'Formularz złota24.pl');
			    $message->setTo('zlota24@onet.pl');  

				 
			       
			    $message->setSubject('Wiadomość z formularza na stronie złota24.pl');
			    $message->setEncoding("UTF-8");
	    		$message->setBody($body);
	    		$message->getHeaders()->get('content-type')->setType('multipart/alternative');
				
				

			    $transport = $this->getServiceLocator()->get('mail.transport');
			    $transport->send($message);	
	    		

	    		
	    		
				$tablica['wynik'] = 'success';
	       		echo json_encode($tablica);
    		} else {
    			$tablica['wynik'] = 'error';
	       		echo json_encode($tablica);
    		}	
    	}
    	return $this->response;
    }

    
	
}
function rpHash($value) { 
    $hash = 5381; 
    $value = strtoupper($value); 
    for($i = 0; $i < strlen($value); $i++) { 
        $hash = (leftShift32($hash, 5) + $hash) + ord(substr($value, $i)); 
    } 
    return $hash; 
} 
 
// Perform a 32bit left shift 
function leftShift32($number, $steps) { 
    // convert to binary (string) 
    $binary = decbin($number); 
    // left-pad with 0's if necessary 
    $binary = str_pad($binary, 32, "0", STR_PAD_LEFT); 
    // left shift manually 
    $binary = $binary.str_repeat("0", $steps); 
    // get the last 32 bits 
    $binary = substr($binary, strlen($binary) - 32); 
    // if it's a positive number return it 
    // otherwise return the 2's complement 
    return ($binary{0} == "0" ? bindec($binary) : 
        -(pow(2, 31) - bindec(substr($binary, 1)))); 
}