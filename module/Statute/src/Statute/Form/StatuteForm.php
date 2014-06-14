<?php 
namespace Statute\Form;

 use Zend\Form\Form;

 class StatuteForm extends Form
 {
     public function __construct($name = null)
     {
         parent::__construct('statute');

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
                 'label' => 'Wprowadź treść',
             ),
             'attributes' => array(
                 'cols' => 120,
                 'rows' => 15,
                 'class' => 'ckeditor',
                 'class' => 'form-control',
                 'id' => 'textarea1'                 
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