<?php
namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Auth\Model\Auth;
use Auth\Form\RegistrationForm;
use Auth\Form\RegistrationFilter;

use Auth\Form\ForgottenPasswordForm;
use Auth\Form\ForgottenPasswordFilter;
// a test class in a coolcsn namespace for installer. You can remove the next line
use CsnBase\Zend\Validator\ConfirmPassword;

use Zend\Mail\Message;

use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class RegistrationController extends AbstractActionController
{
	protected $usersTable;	
	
	public function indexAction()
	{
		// A test instantiation to make sure it works. Not used in the application. You can remove the next line
		// $myValidator = new ConfirmPassword();
		$form = new RegistrationForm();
		//$form->get('submit')->setValue('ZAREJESTRUJ');
		
		// $request = $this->getRequest();
  //       if ($request->isPost()) {
			//$form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
			// $form->setData($request->getPost());
			//  if ($form->isValid()) {			 
			// 	$data = $form->getData();
			// 	$data = $this->prepareData($data);
			// 	$auth = new Auth();
			// 	$auth->exchangeArray($data);

/*				
				// this is replaced by 
				// 1) Manualy composing (wiring) the objects
				$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
				$resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
				$resultSetPrototype->setArrayObjectPrototype(new \Auth\Model\Auth());
				$tableGateway = new \Zend\Db\TableGateway\TableGateway('users', $dbAdapter, null, $resultSetPrototype);
				$usersTable = new \Auth\Model\UsersTable($tableGateway);
				// $usersTable->saveUser($auth);
				// $user7 = $usersTable->getUser(7);
				
				$rowset = $tableGateway->select(array('usr_id' => 7));
				$user7 = $rowset->current();
				
				echo '<pre>';
				var_dump($user7);
				echo '</pre>';
*/
				
				// OR
				// 2) Using the service Locator
				//$this->getUsersTable()->saveUser($auth);
				
				//$this->sendConfirmationEmail($auth);
				//$this->flashMessenger()->addMessage($auth->email);
				//return $this->redirect()->toRoute('auth/default', array('controller'=>'registration', 'action'=>'registration-success'));					
			//}
			// $login = $this->getRequest()->getPost('login');	
   //  		$login = trim($login);	
   //  		$email = $this->getRequest()->getPost('email');	
   //  		$email = trim($email);	
   //  		$password = $this->getRequest()->getPost('password');	
   //  		$password = trim($password);

			// $data = $request->getPost();				
			// $data = $this->prepareData($data);
			// $auth = new Auth();
			// $auth->exchangeArray($data);
			// $this->getUsersTable()->saveUser($auth);
			// $this->sendConfirmationEmail($auth);
			// $this->flashMessenger()->addMessage($auth->email);

		// 	$tablica['wynik'] = 'succes';
  //          	echo json_encode($tablica);

  //          	return $this->response;
		// }
		return new ViewModel(array('form' => $form));
	}
	
	public function registrationSuccessAction()
	{
		$email = null;
		$flashMessenger = $this->flashMessenger();
		if ($flashMessenger->hasMessages()) {
			foreach($flashMessenger->getMessages() as $key => $value) {
				$email .=  $value;
			}
		}
		return new ViewModel(array('email' => $email));
	}	

	public function confirmEmailAction()
	{
		$token = $this->params()->fromRoute('id');
		$viewModel = new ViewModel(array('token' => $token));
		try {
			$user = $this->getUsersTable()->getUserByToken($token);
			$id = $user->id;
			$this->getUsersTable()->activateUser($id);
		}
		catch(\Exception $e) {
			$viewModel->setTemplate('auth/registration/confirm-email-error.phtml');
		}
		return $viewModel;
	}

	public function forgottenPasswordAction()
	{
// 		$form = new ForgottenPasswordForm();
// 		$form->get('submit')->setValue('Send');
// 		$request = $this->getRequest();
//         if ($request->isPost()) {
// 			$form->setInputFilter(new ForgottenPasswordFilter($this->getServiceLocator()));
// 			$form->setData($request->getPost());
// 			 if ($form->isValid()) {
// 				$data = $form->getData();
// 				$email = $data['email'];
// 				$usersTable = $this->getUsersTable();
// 				$auth = $usersTable->getUserByEmail($email);
// 				$password = $this->generatePassword();
// 				$auth->password = $this->encriptPassword($this->getStaticSalt(), $password, $auth->password_salt);
// //				$usersTable->changePassword($auth->usr_id, $password);
// // 				or
// 				$usersTable->saveUser($auth);
// 				$this->sendPasswordByEmail($email, $password);
// 				$this->flashMessenger()->addMessage($email);
//                 return $this->redirect()->toRoute('auth/default', array('controller'=>'registration', 'action'=>'password-change-success'));
// 			}					
// 		}		
// 		return new ViewModel(array('form' => $form));	

		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$data = $request->getPost();
			$email = $data['mail'];
			$usersTable = $this->getUsersTable();
			$auth = $usersTable->getUserByEmail($email);
			$password = $this->generatePassword();
			$auth->password = $this->encriptPassword($this->getStaticSalt(), $password, $auth->password_salt);
			$usersTable->saveUser($auth);
			$this->sendPasswordByEmail($email, $password);
			//$this->flashMessenger()->addMessage($email);	
			$result = new JsonModel(array(
                    'wynik' => $tablica['wynik']                                       
            ));
           	return $result;						
		}		
		return $this->response;					
	}
	
	public function passwordChangeSuccessAction()
	{
		$email = null;
		$flashMessenger = $this->flashMessenger();
		if ($flashMessenger->hasMessages()) {
			foreach($flashMessenger->getMessages() as $key => $value) {
				$email .=  $value;
			}
		}
		return new ViewModel(array('email' => $email));
	}	
	
	public function prepareData($data)
	{
		$data['active'] = 0;
		$data['password_salt'] = $this->generateDynamicSalt();				
		$data['password'] = $this->encriptPassword(
			$this->getStaticSalt(), 
			$data['password'], 
			$data['password_salt']
		);
		//$data['usrl_id'] = 2;
		//$data['lng_id'] = 1;
//		$data['usr_registration_date'] = date('Y-m-d H:i:s');
		$date = new \DateTime();
		$data['registration_date'] = $date->format('Y-m-d H:i:s');
		$data['registration_token'] = md5(uniqid(mt_rand(), true)); // $this->generateDynamicSalt();
//		$data['usr_registration_token'] = uniqid(php_uname('n'), true);	
		$data['email_confirmed'] = 0;
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
	
	public function generatePassword($l = 8, $c = 0, $n = 0, $s = 0) {
		 // get count of all required minimum special chars
		 $count = $c + $n + $s;
		 $out = '';
		 // sanitize inputs; should be self-explanatory
		 if(!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
			  trigger_error('Argument(s) not an integer', E_USER_WARNING);
			  return false;
		 }
		 elseif($l < 0 || $l > 20 || $c < 0 || $n < 0 || $s < 0) {
			  trigger_error('Argument(s) out of range', E_USER_WARNING);
			  return false;
		 }
		 elseif($c > $l) {
			  trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
			  return false;
		 }
		 elseif($n > $l) {
			  trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
			  return false;
		 }
		 elseif($s > $l) {
			  trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
			  return false;
		 }
		 elseif($count > $l) {
			  trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
			  return false;
		 }
	 
		 // all inputs clean, proceed to build password
	 
		 // change these strings if you want to include or exclude possible password characters
		 $chars = "abcdefghijklmnopqrstuvwxyz";
		 $caps = strtoupper($chars);
		 $nums = "0123456789";
		 $syms = "!@#$%^&*()-+?";
	 
		 // build the base password of all lower-case letters
		 for($i = 0; $i < $l; $i++) {
			  $out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		 }
	 
		 // create arrays if special character(s) required
		 if($count) {
			  // split base password to array; create special chars array
			  $tmp1 = str_split($out);
			  $tmp2 = array();
	 
			  // add required special character(s) to second array
			  for($i = 0; $i < $c; $i++) {
				   array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
			  }
			  for($i = 0; $i < $n; $i++) {
				   array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
			  }
			  for($i = 0; $i < $s; $i++) {
				   array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
			  }
	 
			  // hack off a chunk of the base password array that's as big as the special chars array
			  $tmp1 = array_slice($tmp1, 0, $l - $count);
			  // merge special character(s) array with base password array
			  $tmp1 = array_merge($tmp1, $tmp2);
			  // mix the characters up
			  shuffle($tmp1);
			  // convert to string for output
			  $out = implode('', $tmp1);
		 }
	 
		 return $out;
	}
	
    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Auth\Model\UsersTable');
        }
        return $this->usersTable;
    }

	public function sendConfirmationEmail($auth, $viewPass)
	{
		
		// $transport = $this->getServiceLocator()->get('mail.transport');
		// $message = new Message();
		// $this->getRequest()->getServer(); 
		// $message->addTo($auth->email)
		// 		->addFrom('vmadmin@vmadmin.vdl.pl')
		// 		->setSubject('<b>Please, confirm your registration!</b>')
		// 		->setBody("Please, click the link to confirm your registration => " . 
		// 			$this->getRequest()->getServer('HTTP_ORIGIN') .
		// 			$this->url()->fromRoute('auth/default', array(
		// 				'controller' => 'registration', 
		// 				'action' => 'confirm-email', 
		// 				'id' => $auth->registration_token)));
		// $transport->send($message);


$body = "<div style='background: #4ea7df; padding-top:50px; font-size:13px;'>
    <div id='menu' style='width: 100%;height: 50px;background: #115d83;'>
        <div id='logo' style='float: left;position: absolute;margin: 20px 0 0 30px;z-index: 2;'><img src='http://vmadmin.vdl.pl/img/logo.png' style='width: 100%; position: relative; z-index: 1; margin-top: -60px !important;'/></div>
        <div style='width: 200px;height: 35px;background: #fca72a; float: right; margin: 0 15% 0 0;text-align: center;color: white; padding-top: 15px;font-size: 20px;'>Rejestracja</div>
     </div>
            
<div id='main_contener' style='clear:both; position: relative; width: 100%;background: #4ea7df'>
    <div id='tab1' style='color: white;text-align: justify; '>
        <div class='box' style='background: #82c1ea; color: #195a82;padding: 20px; margin: 50px 15% 50px 15%; font-size: 20px;'>   
            Dziękujemy za rejestracje w serwisie volley-masters.com.<br/>
            Poniżej przedstawiono podane dane rejestracyjne:
            <br><br>
            Login:<b>" .  $auth->login ."</b><br>
            Hasło:<b>". $viewPass ."</b><br>
            Aby potwierdzić kliknij poniższy link:<br><span style='color:orange'>" . $this->getRequest()->getServer('HTTP_ORIGIN') .
					$this->url()->fromRoute('auth/default', array(
						'controller' => 'registration', 
						'action' => 'confirm-email', 
						'id' => $auth->registration_token)) . "</span><br>	
            *Jeśli nie rejestrowałeś się w serwisie, proszę zignoruj tę wiadomość.

        </div>
		<div id='footer' style='height: 20px;background: #115d83;  margin: -50px 15% 50px 15%'>
            <div id='copyright' style='float: left;width: auto;line-height: 20px;padding-left: 10px;color: white;'>
                 Copyright © <span style='color:white'>volley-masters.com</span> 2014
             </div>
        </div>
    </div>
</div>
</div>";

		
	    $htmlPart = new MimePart($body);
	    $htmlPart->type = "text/html";

	    $textPart = new MimePart($body);
	    $textPart->type = "text/plain";

	    $body = new MimeMessage();
	    $body->setParts(array($textPart, $htmlPart));

	    $message = new Message();
	    $message->setFrom('vmadmin@vmadmin.vdl.pl');
	    $message->setTo($auth->email);   
	       
	    $message->setSubject('Potwierdzenie rejestracji');
	    $message->setEncoding("UTF-8");
	    $message->setBody($body);
	    $message->getHeaders()->get('content-type')->setType('multipart/alternative');

	    $transport = $this->getServiceLocator()->get('mail.transport');
	    $transport->send($message);	
	}

	public function sendPasswordByEmail($email, $password)
	{
		// $htmlPart = new MimePart($htmlText);
  //   	$htmlPart->type = "text/html";

		// $transport = $this->getServiceLocator()->get('mail.transport');
		// $message = new Message();
		// $this->getRequest()->getServer();  //Server vars
		// $message->addTo($email)
		// 		->addFrom('praktiki@coolcsn.com')
		// 		->setSubject('Your password has been changed!')
		// 		->setBody("Your password at  " . 
		// 			$this->getRequest()->getServer('HTTP_ORIGIN') .
		// 			' has been changed. Your new password is: ' .
		// 			$password . $htmlText
		// 		);
		// $transport->send($message);	

		 $body = "Your password at  " . 
		 			$this->getRequest()->getServer('HTTP_ORIGIN') .
		 			' has been changed. Your new password is: <b>' .
		 			$password . '</b>';
    $htmlPart = new MimePart($body);
    $htmlPart->type = "text/html";

    $textPart = new MimePart($body);
    $textPart->type = "text/plain";

    $body = new MimeMessage();
    $body->setParts(array($textPart, $htmlPart));

    $message = new Message();
    $message->setFrom('vmadmin@vmadmin.vdl.pl');
    $message->setTo($email);   
       
    $message->setSubject('Your password has been changed!');
    $message->setEncoding("UTF-8");
    $message->setBody($body);
    $message->getHeaders()->get('content-type')->setType('multipart/alternative');

    $transport = $this->getServiceLocator()->get('mail.transport');
    $transport->send($message);	
	}


	public function mailAction()
	{
		
		// setup SMTP options
		$options = new Mail\Transport\SmtpOptions(array(
		            'name' => 'vmadmin.vdl.pl',
		            'host' => 'mail.vmadmin.vdl.pl',
		            'port'=> 25,
		            'connection_class' => 'login',
		            'connection_config' => array(
		                'username' => 'vmadmin',
						'password' => 'ywlth5547',
		                'ssl'=> 'tls',
		            ),
		));
		                 
		//$this->renderer = $this->getServiceLocator()->get('ViewRenderer');
		//$content = $this->renderer->render('email/tpl/template', null);
		$content = 'asd';

		// make a header as html
		$html = new MimePart($content);
		$html->type = "text/html";
		$body = new MimeMessage();
		$body->setParts(array($html,));

		// instance mail 
		$mail = new Mail\Message();
		$mail->setBody($body); // will generate our code html from template.phtml
		$mail->setFrom('vmadmin@vmadmin.vdl.pl','Miszcz');
		$mail->setTo('idzikkrzysztof91@gmail.com');
		$mail->setSubject('Your Subject');

		$transport = new Mail\Transport\Smtp($options);
		$transport->send($mail);
		return false;
	
	}

	public function cronAction()
    {
       

		$output1 = fopen('/home/vmadmin/domains/vmadmin.vdl.pl/public_html/public/files/2.csv', 'w');
		fwrite($output1, "idzik");
		

		$this->getUsersTable()->cronTest();
		
        return new ViewModel(array());
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

    public function checkIfEmailExistsAjaxAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost()){
    		//$login = $this->params('login');  
    		$email = $this->getRequest()->getPost('email');	
    		$email = trim($email);	
    		$getEmail = $this->getUsersTable()->findEmail($email);
    		if ($getEmail) {
    			$tablica['wynik'] = 'succes';
           		echo json_encode($tablica);
    		} else {
    			$tablica['wynik'] = 'failed';
           		echo json_encode($tablica);
    		}    		
    	}
    	return $this->response;
    }

    public function saveUserAjaxAction()
    {
    	$request = $this->getRequest();
        if ($request->isPost()) {
        	$data = $request->getPost();
        	$viewPass = $data['password'];				
			$data = $this->prepareData($data);
			$auth = new Auth();
			$auth->exchangeArray($data);
			$this->getUsersTable()->saveUser($auth);
			$this->sendConfirmationEmail($auth, $viewPass);
			$this->flashMessenger()->addMessage($auth->email);

			$tablica['wynik'] = 'succes';
           	echo json_encode($tablica);           	
		}
		return $this->response;
    }

}	