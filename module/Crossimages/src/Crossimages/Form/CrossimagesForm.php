<?php
namespace Crossimages\Form;

use Zend\Form\Form;

class CrossimagesForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'first_row',
            'attributes' => array(
                'type'  => 'text',
				'id' => 'first_row',
				'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Pierwszy wiersz:',
            ),
        ));
        $this->add(array(
            'name' => 'second_row',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'second_row',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Drugi (pogrubiony) wiersz:',
            ),
        ));
    }
}