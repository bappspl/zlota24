<?php
namespace Auth\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('easy');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'text',
                'id' => 'login', 
                'placeholder' => 'Wprowadź login'               
            ),
            'options' => array(
                'label' => 'Login',                
            ),
        ));
		
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'text', 
                'id' => 'email', 
                'placeholder' => 'Wprowadź e-mail'  
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));	
		
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'text', 
                'id' => 'password', 
                'placeholder' => 'Wprowadź hasło' 
            ),
            'options' => array(
                'label' => 'Hasło',
            ),
        ));
		
        $this->add(array(
            'name' => 'password_confirm',
            'attributes' => array(
                'type'  => 'password',
                 'class' => 'text', 
                 'id' => 'password_confirm', 
                'placeholder' => 'Powtórz hasło' 
            ),
            'options' => array(
                'label' => 'Powtórz hasło',
            ),
        ));	

		// $this->add(array(
		// 	'type' => 'Zend\Form\Element\Captcha',
		// 	'name' => 'captcha',
		// 	'options' => array(
		// 		'label' => 'Please verify you are human',
		// 		'captcha' => new \Zend\Captcha\Figlet(),
		// 	),
		// ));
		
        // $this->add(array(
        //     'name' => 'submit',
        //     'attributes' => array(
        //         'type'  => 'submit',
        //         'value' => 'Go',
        //         'id' => 'send_message',
        //         'class' => 'button',
        //         'disabled' => true
        //     ),
        // )); 
    }
}