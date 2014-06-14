<?php
namespace CmsSettings\Form;

use Zend\Form\Form;

class CmsSettingsForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'oldPassword',
            'attributes' => array(
                'type'  => 'text',
				'id' => 'oldPassword',
				'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Stare hasło:',
            ),
        ));	
        $this->add(array(
            'name' => 'newPassword',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'newPassword',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Nowe hasło:',
            ),
        ));	
        $this->add(array(
            'name' => 'newPasswordRepeat',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'newPasswordRepeat',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Powtórz nowe hasło:',
            ),
        )); 
    }
}