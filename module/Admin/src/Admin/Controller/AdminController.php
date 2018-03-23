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
        return new ViewModel();
    }
    
    public function adminAuthAction(){
        if ($this->getRequest()->isPost()) {
            $sm = $this->getServiceLocator();
            $userEmailID = $this->params()->fromPost('email');
            $password = $this->params()->fromPost('password');             
            $adminUser = new AdminUser();
            $login = $adminUser->login($sm->get('dbAdapter'), $userEmailID, $password);
            if($login){
                $admin_session = new Container('eLearningAdmin');
                $admin_session->emailID = $adminUser->getAdminEmailID();
                $admin_session->userID = $adminUser->getAdminUserID();
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

    public function adminPortalAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }

}

