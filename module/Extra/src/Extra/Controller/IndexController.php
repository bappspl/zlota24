<?php

namespace Extra\Controller;

use Extra\Model;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Extra\Model\Extra;
use Zend\Db\TableGateway\TableGateway;
use Extra\Form\ExtraForm;

class IndexController extends AbstractActionController
{
	protected $extraTable;

	public function getExtraTable()
    {
        if (!$this->extraTable) {
            $sm = $this->getServiceLocator();
            $this->extraTable = $sm->get('Extra\Model\ExtraTable');
        } 
        return $this->extraTable;
    }

    public function indexAction()
    {
        $this->layout('layout/layout-extra.phtml');
        $extra = $this->getExtraTable()->getById(1);
       return new ViewModel(array('extra' => $extra));       
    }  

    public function editAction()
    {
       $this->layout('layout/layout-extra.phtml');
       $form = new ExtraForm();
       $extra = $this->getExtraTable()->getById(1);
       $data = array(
            'image' => $extra->image,
            'description_1' => $extra->description_1            
        ); 
       $form->setData($data);
       $request = $this->getRequest();
      if ($request->isPost()) {
          $extra = new Extra();            
          $form->setData($request->getPost());
          if ($form->isValid()) {
              $extra->exchangeArray($form->getData());
              $this->getExtraTable()->addExtra($extra);                
              return $this->redirect()->toRoute('extra');
          }
      }
       return array('form' => $form,
                    'image' => $extra->image
      );      
    }  

    public function checkExistPhotoAjaxAction()
    {   
      if($this->getRequest()->isPost()){
          $a = $this->getRequest()->getPost("filename");
          $targetFolder = 'public/img/extra'; 
          if (file_exists($targetFolder . '/' . $a)) {
              echo '1';
          } else {
              echo '0';
          }
      }
      return $this->response;  
    } 

    public function uploadifyAjaxAction(){
        $targetFolder = 'public/img/extra'; 
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];            
            $targetFile = rtrim($targetFolder,'/') . '/' . $_FILES['Filedata']['name'];
            move_uploaded_file($tempFile,$targetFile);
            echo '1';          
        }
        return $this->response;
    }
}