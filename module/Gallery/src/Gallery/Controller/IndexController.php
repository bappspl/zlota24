<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Gallery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Model\Auth;
use Zend\Authentication\AuthenticationService;

use Gallery\Model;
use Gallery\Model\Gallery;
use Gallery\Model\Galleryicon;
use Gallery\Model\Icon;
use Gallery\Model\Photos;
use Gallery\Form\GalleryForm;

use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    protected $galleryTable;
    protected $galleryiconTable;
    protected $iconTable;
    protected $photosTable;
    public function getGalleryTable()
    {
        if (!$this->galleryTable) {
            $sm = $this->getServiceLocator();
            $this->galleryTable = $sm->get('Gallery\Model\GalleryTable');
        } 
        return $this->galleryTable;
    }
    public function getGalleryiconTable()
    {
        if (!$this->galleryiconTable) {
            $sm = $this->getServiceLocator();
            $this->galleryiconTable = $sm->get('Gallery\Model\GalleryiconTable');
        } 
        return $this->galleryiconTable;
    }
    public function getIconTable()
    {
        if (!$this->iconTable) {
            $sm = $this->getServiceLocator();
            $this->iconTable = $sm->get('Gallery\Model\IconTable');
        } 
        return $this->iconTable;
    }
    public function getPhotosTable()
    {
        if (!$this->photosTable) {
            $sm = $this->getServiceLocator();
            $this->photosTable = $sm->get('Gallery\Model\PhotosTable');
        } 
        return $this->photosTable;
    }
    public function indexAction()
    {
        $this->layout('layout/layout-gallery.phtml');
    	$auth = new AuthenticationService();
         if ($auth->hasIdentity()) {	
            $allGalleries = $this->getGalleryTable()->getAllGalleries();		
			return new ViewModel(array('listGalleries' => $allGalleries));                        
        } else {
			return $this->redirect()->toUrl('/');
		}
    }

    public function addAction()
    {
        $this->layout('layout/layout-gallery.phtml');
        $auth = new AuthenticationService();
         if ($auth->hasIdentity()) { 
            $allIcons = $this->getIconTable()->getAllIcons();
            $allIcons2 = $this->getIconTable()->getAllIcons();
            $form = new GalleryForm();
            return new ViewModel(array('form' => $form, 'icons' => $allIcons, 'icons2' => $allIcons2));
        } else {
            return $this->redirect()->toUrl('/');
        }
    }
    public function editAction()
    {
        $this->layout('layout/layout-gallery.phtml');
        $auth = new AuthenticationService();
         if ($auth->hasIdentity()) { 
            $id = $this->params()->fromRoute('id');
            $galleryData = $this->getGalleryTable()->getAllDataById($id);
            $icons = $this->getGalleryiconTable()->getAllIconsById($id);
            $photos = $this->getPhotosTable()->getAllPhotosById($id);
            $allIcons = $this->getIconTable()->getAllIcons();
            $allIcons2 = $this->getIconTable()->getAllIcons();

            $tmpIconTab = array();
            foreach ($icons as $icon) {
                array_push($tmpIconTab, $icon->id_icon);
            }
            $form = new GalleryForm();
            $tmpArray = array(
                'id' => $galleryData->id,
                'name' => $galleryData->name,
                'price' => $galleryData->price,
                'description' => $galleryData->description
            );
            $form->setData($tmpArray);
            return array(
                 'id' => $id,
                 'form' => $form,
                 'icons' => $tmpIconTab,
                 'photos' => $photos,
                 'allIcons' => $allIcons,
                 'allIcons2' => $allIcons2,
                 'image' => $galleryData->image
             );
        } else {
            return $this->redirect()->toUrl('/');
        }
    }
    public function previewAction()
    {
        $this->layout('layout/layout-gallery.phtml');
        $auth = new AuthenticationService();
         if ($auth->hasIdentity()) { 
            $id = $this->params()->fromRoute('id');
            $galleryData = $this->getGalleryTable()->getAllDataById($id);
            $icons = $this->getGalleryiconTable()->getAllIconsById($id);
            $photos = $this->getPhotosTable()->getAllPhotosById($id);
            $allIcons = $this->getIconTable()->getAllIcons();

            $tmpIconTab = array();
            foreach ($icons as $icon) {
                array_push($tmpIconTab, $icon->id_icon);
            }
            $form = new GalleryForm();
            $tmpArray = array(
                'id' => $galleryData->id,
                'name' => $galleryData->name,
                'price' => $galleryData->price,
                'description' => $galleryData->description
            );
            $form->setData($tmpArray);
            return array(
                 'id' => $id,
                 'form' => $form,
                 'icons' => $tmpIconTab,
                 'photos' => $photos,
                 'allIcons' => $allIcons,
                 'image' => $galleryData->image
             );
        } else {
            return $this->redirect()->toUrl('/');
        }
    }
    public function saveGalleryInfoAjaxAction () {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $name = $this->getRequest()->getPost('sName');
            $price = $this->getRequest()->getPost('sPrice');
            $description = $this->getRequest()->getPost('sDescription');
            $icons = $this->getRequest()->getPost('sIcons');
            $idNewGallery = $this->getGalleryTable()->saveGalleryInfo($name, $price, $description);
            $this->getGalleryiconTable()->saveIconToGallery($idNewGallery, $icons);
            
            $result = new JsonModel(array(
                    'wynik' => 'success',
                    'idGallery' =>  $idNewGallery                 
            ));
           return $result;
        }
    }
    public function saveGalleryThumbAjaxAction () {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $image = $this->getRequest()->getPost('sImage');
            $idGallery = $this->getRequest()->getPost('idGallery');
            $this->getGalleryTable()->saveGalleryThumb($idGallery, $image);
            $result = new JsonModel(array(
                    'wynik' => 'success',
                    'tmp' => $image            
            ));
           return $result;
        }
    }
     public function saveEditGalleryInfoAjaxAction () {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $id = $this->getRequest()->getPost('sId');
            $name = $this->getRequest()->getPost('sName');
            $price = $this->getRequest()->getPost('sPrice');
            $description = $this->getRequest()->getPost('sDescription');
            $icons = $this->getRequest()->getPost('sIcons');
            $this->getGalleryTable()->saveEditGalleryInfo($id, $name, $price, $description);
            $this->getGalleryiconTable()->saveEditIconToGallery($id, $icons);
            
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
            $targetFolder = 'public/img/gallery'; 
            if (file_exists($targetFolder . '/' . $a)) {
                echo '1';
            } else {
                echo '0';
            }
        }
        return $this->response;
    }

    public function uploadPhotoGalleryAjaxAction()
    {      
        $uploadDir = 'public/img/gallery/';

        if (!empty($_FILES)) {
          $tempFile   = $_FILES['Filedata']['tmp_name'][0];
          $targetFile = $uploadDir . $_FILES['Filedata']['name'][0];

          // Validate the file type
          $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions
          $fileParts = pathinfo($_FILES['Filedata']['name'][0]);

          // Validate the filetype
          if (in_array($fileParts['extension'], $fileTypes)) {

            $idGallery = $this->getRequest()->getPost('idGallery');
            $this->getPhotosTable()->saveImageToGallery($idGallery, $targetFile);
            move_uploaded_file($tempFile,$targetFile);
            echo 1;

          } else {

            // The file type wasn't allowed
            echo 'Invalid file type.';

          }
        }
        return $this->response; 
    }

    public function uploadEditPhotoGalleryAjaxAction()
    {       
       $uploadDir = 'public/img/gallery/';

        if (!empty($_FILES)) {
          $tempFile   = $_FILES['Filedata']['tmp_name'][0];
          $targetFile = $uploadDir . $_FILES['Filedata']['name'][0];

          // Validate the file type
          $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions
          $fileParts = pathinfo($_FILES['Filedata']['name'][0]);

          // Validate the filetype
          if (in_array($fileParts['extension'], $fileTypes)) {

            $idGallery = $this->getRequest()->getPost('idGallery');
            $id = $this->getPhotosTable()->saveEditImageToGallery($idGallery, $targetFile);
            move_uploaded_file($tempFile,$targetFile);
            echo 1;

          } else {

            // The file type wasn't allowed
            echo 'Invalid file type.';

          }
        }
        return $this->response;
    }

    public function deletePhotoAjaxAction()
    {
        if($this->getRequest()->isPost()){
            $a = $this->getRequest()->getPost("idPhoto");
            $this->getPhotosTable()->deletePhotoById($a);

            $result = new JsonModel(array(
                    'wynik' => 'success'                
            ));
           return $result;
        }
    }
    public function deleteGalleryAjaxAction()
    {
        if($this->getRequest()->isPost()){
            $id = $this->getRequest()->getPost("idGallery");
            $this->getPhotosTable()->deleteAllPhotosByGalleryId($id);
            $this->getGalleryiconTable()->deleteAllIconByGalleryId($id);
            $this->getGalleryTable()->deleteGalleryById($id);
            $result = new JsonModel(array(
                    'wynik' => 'success'                
            ));
           return $result;
        }
    }
}
