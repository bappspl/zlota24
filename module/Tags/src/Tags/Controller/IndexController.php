<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tags\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Model\Auth;
use Zend\Authentication\AuthenticationService;

use Tags\Model;
use Tags\Model\Tags;

use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    protected $tagsTable;
    public function getTagsTable()
    {
        if (!$this->tagsTable) {
            $sm = $this->getServiceLocator();
            $this->tagsTable = $sm->get('Tags\Model\TagsTable');
        } 
        return $this->tagsTable;
    }
    public function indexAction()
    {
        $this->layout('layout/layout-tags.phtml');
    	$auth = new AuthenticationService();
         if ($auth->hasIdentity()) {	
            $tagsList = $this->getTagsTable()->getAllTags();
            return new ViewModel(array('tagsList' => $tagsList));                      
        } else {
			return $this->redirect()->toUrl('/');
		}
    }
    
   
    public function saveNewTagAjaxAction() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $addNewTag = $this->getRequest()->getPost('sAddNewTag');
            
           $tagData = $this->getTagsTable()->saveNewTag($addNewTag);
            
            $result = new JsonModel(array(
                'wynik' => 'success',
                'id' => $tagData['id'],
                'i' => $tagData['i']         
            ));
           return $result;
        }
    }

    public function deleteTagAjaxAction(){
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $id = $this->getRequest()->getPost('sId');
            
            $this->getTagsTable()->deleteTag($id);
            
            $result = new JsonModel(array(
                'wynik' => 'success'        
            ));
           return $result;
        }
    }

    public function saveEditTagAjaxAction() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $id = $this->getRequest()->getPost('sId');
            $name = $this->getRequest()->getPost('sEditNewTag');

            $this->getTagsTable()->saveEditTag($id, $name);
            
            $result = new JsonModel(array(
                'wynik' => 'success'         
            ));
           return $result;
        }
    }
}
