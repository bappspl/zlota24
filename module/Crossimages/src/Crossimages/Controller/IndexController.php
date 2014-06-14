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
                 'form' => $form
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
                 'form' => $form
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
            
            $this->getCrossimagesTable()->saveEditCrossimages($id, $fristRow, $secondRow);
            $result = new JsonModel(array(
                    'wynik' => 'success'          
            ));
           return $result;
        }
    }
}
