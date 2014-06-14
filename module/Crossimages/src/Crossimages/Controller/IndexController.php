<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Crossimages\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Model\Auth;
use Zend\Authentication\AuthenticationService;

use Crossimages\Model;
use Crossimages\Model\Crossimages;
use Crossimages\Form\CrossimagesForm;

use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    protected $crossimagesTable;
    public function getCrossimagesTable()
    {
        if (!$this->crossimagesTable) {
            $sm = $this->getServiceLocator();
            $this->crossimagesTable = $sm->get('Crossimages\Model\CrossimagesTable');
        } 
        return $this->crossimagesTable;
    }
    public function indexAction()
    {
        $this->layout('layout/layout-crossimages.phtml');
    	$auth = new AuthenticationService();
         if ($auth->hasIdentity()) {	
            $allCrossimages = $this->getCrossimagesTable()->getAllCrossimages();		
			return new ViewModel(array('listCrossimages' => $allCrossimages));                        
        } else {
			return $this->redirect()->toUrl('/');
		}
    }
    public function editAction()
    {
        $this->layout('layout/layout-crossimages.phtml');
        $auth = new AuthenticationService();
         if ($auth->hasIdentity()) { 
            $id = $this->params()->fromRoute('id');
            $crossimagesData = $this->getCrossimagesTable()->getCrossimagesById($id);

            $form = new CrossimagesForm();
            $tmpArray = array(
                'id' => $crossimagesData->id,
                'first_row' => $crossimagesData->first_row,
                'second_row' => $crossimagesData->second_row

            );
            $form->setData($tmpArray);
            return array(
                 'id' => $id,
                 'form' => $form,
                 'image' => $crossimagesData->image
             );
        } else {
            return $this->redirect()->toUrl('/');
        }
    }
    public function previewAction()
    {
        $this->layout('layout/layout-crossimages.phtml');
        $auth = new AuthenticationService();
         if ($auth->hasIdentity()) { 
            $id = $this->params()->fromRoute('id');
            $crossimagesData = $this->getCrossimagesTable()->getCrossimagesById($id);

            $form = new CrossimagesForm();
            $tmpArray = array(
                'id' => $crossimagesData->id,
                'first_row' => $crossimagesData->first_row,
                'second_row' => $crossimagesData->second_row
            );
            $form->setData($tmpArray);
            return array(
                 'id' => $id,
                 'form' => $form,
                 'image' => $crossimagesData->image
             );
        } else {
            return $this->redirect()->toUrl('/');
        }
    }
    public function saveEditCrossimagesAjaxAction() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $id = $this->getRequest()->getPost('sId');
            $fristRow = $this->getRequest()->getPost('sFirst_row');
            $secondRow = $this->getRequest()->getPost('sSecond_row');
            $photo = $this->getRequest()->getPost('sPhoto');
            $this->getCrossimagesTable()->saveEditCrossimages($id, $fristRow, $secondRow, $photo);
            $result = new JsonModel(array(
                    'wynik' => 'success'          
            ));
           return $result;
        }
    }
    public function checkExistPhotoAjaxAction()
    {   
      if($this->getRequest()->isPost()){
          $a = $this->getRequest()->getPost("filename");
          $targetFolder = 'public/img/clearfix'; 
          if (file_exists($targetFolder . '/' . $a)) {
              echo '1';
          } else {
              echo '0';
          }
      }
      return $this->response;  
    } 

    public function uploadifyAjaxAction(){
        $uploadDir = 'public/img/clearfix/';

        if (!empty($_FILES)) {
          $tempFile   = $_FILES['Filedata']['tmp_name'][0];
          $targetFile = $uploadDir . $_FILES['Filedata']['name'][0];

          // Validate the file type
          $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions
          $fileParts = pathinfo($_FILES['Filedata']['name'][0]);

          // Validate the filetype
          if (in_array($fileParts['extension'], $fileTypes)) {
            move_uploaded_file($tempFile,$targetFile);
            echo 1;

          } else {

            // The file type wasn't allowed
            echo 'Invalid file type.';

          }
        }
        return $this->response;
    }
}
