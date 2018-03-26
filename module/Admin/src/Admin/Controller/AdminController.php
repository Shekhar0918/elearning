<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Admin\Model\AdminUser;

class AdminController extends AbstractActionController
{

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function adminAuthAction(){
        if ($this->getRequest()->isPost()) {
            $sm = $this->getServiceLocator();
            $userEmailID = $this->params()->fromPost('email');
            $password = $this->params()->fromPost('password');             
            $adminUser = new AdminUser();
            $login = $adminUser->login($sm->get('dbAdapter'), $userEmailID, $password);
            if($login){
                $adminSession = new Container('eLearningAdmin');
                $adminSession->emailID = $adminUser->getAdminEmailID();
                $adminSession->userID = $adminUser->getAdminUserID();
                return $this->redirect()->toRoute('adminPortal');
            }else{
                $this->flashMessenger()->addMessage(json_encode(array("status" => "invalid", "message" => 'Invalid Email or Password')));
                return $this->redirect()->toRoute('adminPortalLogin');
            }
        }
    }
    
    public function adminPortalLoginAction(){
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function logoutAction(){
        $adminSession = new Container('eLearningAdmin');
        $adminSession->getManager()->getStorage()->clear('eLearningAdmin');
        return $this->redirect()->toRoute('adminPortalLogin');
    }

    public function adminPortalAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function getAdminUserInfoAction(){
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'login')));
        }
        $sm = $this->getServiceLocator();
        $adminUserID = $adminSession->userID;
        $adminUser = new AdminUser();
        $adminUser->setAdminUserID($adminUserID);
        $adminUserInfo = $adminUser->getAdminUserInfoByUserID($sm->get('dbAdapter'));
        die(json_encode($adminUserInfo));
    }

}

