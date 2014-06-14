<?php
namespace Video\Form;

use Zend\Form\Form;

class VideoForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'link',
            'attributes' => array(
                'type'  => 'text',
				'id' => 'link',
				'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Link do filmu:',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'description',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Opis filmu:',
            ),
        ));
    }
}