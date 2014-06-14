<?php
namespace Auth\Form;

use Zend\Form\Form;

class AuthForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('easy');
        //$this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'id' => 'login-username', 
                'placeholder' => 'login'
            ),
            'options' => array(
                'label' => 'Login',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control', 
                'id' => 'login-password', 
                'placeholder' => 'hasło' 
            ),
            'options' => array(
                'label' => 'Hasło',
            ),
        ));
        $this->add(array(
            'name' => 'rememberme',
			'type' => 'checkbox', 
            'id' => 'rememberme-log',
            
            // 'Zend\Form\Element\Checkbox',			
//            'attributes' => array( // Is not working this way
//                'type'  => '\Zend\Form\Element\Checkbox',
//            ),
            'options' => array(
                'label' => 'Zapamiętaj mnie',
//				'checked_value' => 'true', without value here will be 1
//				'unchecked_value' => 'false', // witll be 1
            ),
        ));			
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Zaloguj',
                'id' => 'btn-login',
                'class' => 'btn btn-success'
            ),
        )); 
    }
}