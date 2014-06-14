<?php 
namespace Offer\Form;

 use Zend\Form\Form;

 class OfferForm extends Form
 {
     public function __construct($name = null)
     {
         parent::__construct('offer');

         $this->add(array(
             'name' => 'image',
             'type' => 'Hidden',
             'attributes' => array(                
                 'id' => 'image'            
             ),
         ));
         $this->add(array(
             'name' => 'description_1',
             'type' => 'textarea',
             'options' => array(
                 'label' => 'Wprowadź treść - boks 1: ',
             ),
             'attributes' => array(
                 'cols' => 50,
                 'rows' => 10,
                 'class' => 'ckeditor',
                 'class' => 'form-control',
                 'id' => 'textarea1'                 
             ),
         ));
         $this->add(array(
             'name' => 'description_2',
             'type' => 'textarea',
             'options' => array(
                 'label' => 'Wprowadź treść - boks 2: ',
             ),
             'attributes' => array(
                 'cols' => 50,
                 'rows' => 10,
                 'class' => 'ckeditor',
                 'class' => 'form-control',
                 'id' => 'textarea2'                 
             ),
         ));
         $this->add(array(
             'name' => 'description_3',
             'type' => 'textarea',
             'options' => array(
                 'label' => 'Wprowadź treść - boks 3: ',
             ),
             'attributes' => array(
                 'cols' => 50,
                 'rows' => 10,
                 'class' => 'ckeditor',
                 'class' => 'form-control',
                 'id' => 'textarea3'                 
             ),
         ));
         $this->add(array(
            'name' => 'image-upload',
            'attributes' => array(
                'type'  => 'file',
                'id' => 'image-upload'
            ),
            'options' => array(
                'label' => 'Wybierz zdjęcie:',
            ),
        ));          
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',             
             'attributes' => array(
                 'value' => 'Edytuj',
                 'class' => 'btn btn-primary',
                 'id' => 'submit',
             ),
         ));            
     }
 }
?>