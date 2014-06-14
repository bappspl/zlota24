<?php

namespace Offer\Controller;

use Offer\Model;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Offer\Model\Offer;
use Zend\Db\TableGateway\TableGateway;
use Offer\Form\OfferForm;

class IndexController extends AbstractActionController
{
	protected $offerTable;

	public function getOfferTable()
    {
        if (!$this->offerTable) {
            $sm = $this->getServiceLocator();
            $this->offerTable = $sm->get('Offer\Model\OfferTable');
        } 
        return $this->offerTable;
    }

    public function indexAction()
    {
       $this->layout('layout/layout-offer.phtml');
       $offer = $this->getOfferTable()->getById(1);
       return new ViewModel(array('offer' => $offer));
    }  

    public function editAction()
    {
       $this->layout('layout/layout-offer.phtml');
       $form = new OfferForm();
       $offer = $this->getOfferTable()->getById(1);
       $data = array(
            'image' => $offer->image,
            'description_1' => $offer->description_1,
            'description_2' => $offer->description_2,
            'description_3' => $offer->description_3
        ); 
       $form->setData($data);
       $request = $this->getRequest();
      if ($request->isPost()) {
          $offer = new Offer();            
          $form->setData($request->getPost());
          if ($form->isValid()) {
              $offer->exchangeArray($form->getData());
              $this->getOfferTable()->addOffer($offer);                
              return $this->redirect()->toRoute('offer');
          }
      }
       return array('form' => $form,
                    'image' => $offer->image
      );      
    }  

    public function checkExistPhotoAjaxAction()
    {   
      if($this->getRequest()->isPost()){
          $a = $this->getRequest()->getPost("filename");
          $targetFolder = 'public/img/offer'; 
          if (file_exists($targetFolder . '/' . $a)) {
              echo '1';
          } else {
              echo '0';
          }
      }
      return $this->response;  
    } 

    public function uploadifyAjaxAction(){
        $targetFolder = 'public/img/offer'; 
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];            
            $targetFile = rtrim($targetFolder,'/') . '/' . $_FILES['Filedata']['name'];
            move_uploaded_file($tempFile,$targetFile);
            echo '1';          
        }
        return $this->response;
    }
}