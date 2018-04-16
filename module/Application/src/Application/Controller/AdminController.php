<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Application\Model\AdminUser;
use Application\Model\Program;

class AdminController extends AbstractActionController
{

    public function indexAction(){
        $this->layout('layout/admin');
        return new ViewModel();
    }
    
    public function adminAuthAction() {
        $this->layout('layout/admin');
        if ($this->getRequest()->isPost()) {
            $sm = $this->getServiceLocator();
            $userEmailID = $this->params()->fromPost('email');
            $password = $this->params()->fromPost('password');
            $adminUser = new AdminUser();
            $login = $adminUser->login($sm->get('dbAdapter'), $userEmailID, $password);
            if ($login) {
                $adminSession = new Container('eLearningAdmin');
                $adminSession->emailID = $adminUser->getAdminEmailID();
                $adminSession->userID = $adminUser->getAdminUserID();
                return $this->redirect()->toRoute('adminPortal');
            } else {
                $this->flashMessenger()->addMessage(json_encode(array("status" => "invalid", "message" => 'Invalid Email or Password')));
                return $this->redirect()->toRoute('adminPortalLogin');
            }
        }
    }

    function adminPortalLoginAction() {
//        $this->layout('layout/adminPortal-layout');
        $this->layout('layout/admin/login');
        $viewModel = new ViewModel();
//        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function adminLogoutAction() {
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        $adminSession->getManager()->getStorage()->clear('eLearningAdmin');
        return $this->redirect()->toRoute('adminPortalLogin');
    }

    public function adminPortalAction() {
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            return $this->redirect()->toRoute('eLearningAdmin');
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function getAdminUserInfoAction() {
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $adminUserID = $adminSession->userID;
        $adminUser = new AdminUser();
        $adminUser->setAdminUserID($adminUserID);
        $adminUserInfo = $adminUser->getAdminUserInfoByUserID($sm->get('dbAdapter'));
        die(json_encode($adminUserInfo));
    }

    public function getAllProgramsAction() {
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $program = new Program();
        $allEnrolledPrograms = $program->getAllPrograms($sm->get('dbAdapter'));
        die(json_encode($allEnrolledPrograms));
    }

    public function createProgramAction() {
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $program_data = json_decode($this->getRequest()->getContent());
//        echo json_encode($program_data);die();
        $program = new Program();
        $program->createProgram($sm->get('dbAdapter'), $program_data);
        die(json_encode(array("status" => "success", "message" => "New Program has been created")));
    }

    public function updateProgramAction() {
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $program_data = json_decode($this->getRequest()->getContent());
        $program = new Program();
        $program->updateProgram($sm->get('dbAdapter'), $program_data);
        die(json_encode(array("status" => "success")));
    }

    public function deleteProgramAction() {
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $program_data = json_decode($this->getRequest()->getContent());
        $programID = $program_data->program_id;
        $program = new Program();
        $program->setProgramID($programID);
        $program->deleteProgram($sm->get('dbAdapter'));
        die(json_encode(array("status" => "success")));
    }

    public function addProgramChapterAction() {
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $program_data = json_decode($this->getRequest()->getContent());
        $program = new Program();
        $program->addProgramChapter($sm->get('dbAdapter'), $program_data);
        die(json_encode(array("status" => "success")));
    }
    
    public function publishProgramAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $program_data = json_decode($this->getRequest()->getContent());
        $programID = $program_data->program_id;
        $response = Program::updateProgramPublishStatus($sm->get('dbAdapter'), $programID);
        die(json_encode(array("status" => true, "message" => $response["message"])));
    }
    
    public function instructorDashboardAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function addProgramAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }


}

