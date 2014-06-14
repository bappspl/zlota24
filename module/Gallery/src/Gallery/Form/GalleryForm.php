<?php
namespace Gallery\Form;

use Zend\Form\Form;

class GalleryForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
				'id' => 'name',
				'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Nazwa galerii:',
            ),
        ));
		$this->add(array(
             'name' => 'price',
             'type' => 'textarea',
             'options' => array(
                 'label' => 'Tekst pod zdjęciem:',
             ),
             'attributes' => array(
                 'class' => 'form-control',
                 'id' => 'price'                
             ),
         ));
        $this->add(array(
             'name' => 'description',
             'type' => 'textarea',
             'options' => array(
                 'label' => 'Opis:',
             ),
             'attributes' => array(
                 'class' => 'ckeditor',
                 'class' => 'form-control',
                 'id' => 'description'                 
             ),
         ));
    }
}