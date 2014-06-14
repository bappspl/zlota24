<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Video\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Model\Auth;
use Zend\Authentication\AuthenticationService;

use Video\Model;
use Video\Model\Video;
use Video\Form\VideoForm;

use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    protected $videoTable;
    public function getVideoTable()
    {
        if (!$this->videoTable) {
            $sm = $this->getServiceLocator();
            $this->videoTable = $sm->get('Video\Model\VideoTable');
        } 
        return $this->videoTable;
    }
    public function indexAction()
    {
        $this->layout('layout/layout-video.phtml');
    	$auth = new AuthenticationService();
         if ($auth->hasIdentity()) {	
            $videoData = $this->getVideoTable()->getVideoData();

			$form = new VideoForm();
            $tmpArray = array(
                'id' => $videoData->id,
                'link' => $videoData->link                
            );
            $form->setData($tmpArray);
            return array(
                 'id' => 1,
                 'form' => $form,
                 'description' => $videoData->description
             );                       
        } else {
			return $this->redirect()->toUrl('/');
		}
    }
    public function editAction()
    {
        $this->layout('layout/layout-video.phtml');
        $auth = new AuthenticationService();
         if ($auth->hasIdentity()) {    
            $videoData = $this->getVideoTable()->getVideoData();

            $form = new VideoForm();
            $tmpArray = array(
                'id' => $videoData->id,
                'link' => $videoData->link                
            );
            $form->setData($tmpArray);
            return array(
                 'id' => 1,
                 'form' => $form,
                 'description' => $videoData->description
             );                       
        } else {
            return $this->redirect()->toUrl('/');
        }
    }
   
    public function saveEditVideoAjaxAction() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $id = $this->getRequest()->getPost('sId');
            $link = $this->getRequest()->getPost('sLink');
            $pos = strpos($link, '=');
            $description = substr($link, $pos+1, strlen($link));
            $this->getVideoTable()->saveEditVideo($id, $link, $description);
            $result = new JsonModel(array(
                    'wynik' => 'success'         
            ));
           return $result;
        }
    }
}
