<?php

namespace Statute\Controller;

use Statute\Model;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Statute\Model\Statute;
use Zend\Db\TableGateway\TableGateway;
use Statute\Form\StatuteForm;

class IndexController extends AbstractActionController
{
	protected $statuteTable;

	public function getStatuteTable()
    {
        if (!$this->statuteTable) {
            $sm = $this->getServiceLocator();
            $this->statuteTable = $sm->get('Statute\Model\StatuteTable');
        } 
        return $this->statuteTable;
    }

    public function indexAction()
    {
        $this->layout('layout/layout-statute.phtml');
        $statute = $this->getStatuteTable()->getById(1);        
       return new ViewModel(array('statute' => $statute));       
    }  

    public function editAction()
    {
       $this->layout('layout/layout-statute.phtml');
       $form = new StatuteForm();
       $statute = $this->getStatuteTable()->getById(1);
       $data = array(            
            'description_1' => $statute->description_1            
        ); 
       $form->setData($data);
       $request = $this->getRequest();
      if ($request->isPost()) {
          $statute = new Statute();            
          $form->setData($request->getPost());
          if ($form->isValid()) {
              $statute->exchangeArray($form->getData());
              $this->getStatuteTable()->addStatute($statute);                
              return $this->redirect()->toRoute('statute');
          }
      }
       return array('form' => $form                  
      );      
    }     
}