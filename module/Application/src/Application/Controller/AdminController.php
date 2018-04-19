<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Application\Model\AdminUser;
use Application\Model\Program;
use Application\Model\Course;

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
    
    public function manageCoursesAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function addBasicInfoAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function createNewCourseAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $course = new Course();
        $response = $course->createNewCourse($sm->get('dbAdapter'));
        die(json_encode($response));
    }
    
    public function instructorManageCoursesAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function updateCourseBasicInfoAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $courseBasicInfo = json_decode($this->getRequest()->getContent());
        $course = new Course();
        $course->setCourseID(isset($courseBasicInfo->course_id) ? $courseBasicInfo->course_id : "");
        $course->setCourseName(isset($courseBasicInfo->course_name) ? $courseBasicInfo->course_name : "");
        $course->setCourseDescription(isset($courseBasicInfo->course_description) ? $courseBasicInfo->course_description : "");
        $course->setCourseOverview(isset($courseBasicInfo->course_overview) ? $courseBasicInfo->course_overview : "");
        $course->updateCourseBasicInfo($sm->get('dbAdapter'));
        die(json_encode(array("status" => "success")));
    }
    
    public function getCourseDetailsByIDAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $courseID = $this->params()->fromQuery("courseID");
//        $courseDetails = Course::getCourseByID($sm->get('dbAdapter'), $courseID);
        $course = new Course();
        $course->setCourseID($courseID);
        $courseDetails = $course->getCouseDetailsByID($sm->get('dbAdapter'));
        die(json_encode($courseDetails));
    }
    
    public function instructorManageCoursePricingAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function manageCourseInstructorsAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function updateCoursePriceAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $courseData = json_decode($this->getRequest()->getContent());
        $courseID = $courseData->courseID;
        $price = $courseData->price;
        $course = new Course();
        $course->setCourseID($courseID);
        $course->setCoursePrice($price);
        $course->updateCoursePrice($sm->get('dbAdapter'));
        die(json_encode(array("status" => "success")));
    }
    
    public function addCourseInstructorAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $courseData = json_decode($this->getRequest()->getContent());
        $courseID = $courseData->courseID;
        $instructorName = $courseData->instructorName;
        $instructorEmail = $courseData->instructorEmail;
        $course = new Course();
        $course->setCourseID($courseID);
        $course->setInstructorName($instructorName);
        $course->setInstructorEmail($instructorEmail);
        $course->addCourseInstructor($sm->get('dbAdapter'));
        die(json_encode(array("statuc" => "success")));
    }
    
    public function instructorManageCourseChaptersAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function createCourseChapterAction(){
        $this->layout('layout/admin');
        $adminSession = new Container('eLearningAdmin');
        if (!isset($adminSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'adminPortalLogin')));
        }
        $sm = $this->getServiceLocator();
        $courseData = json_decode($this->getRequest()->getContent());
        $courseID = $courseData->courseID;
        $chapter = $courseData->chapter;
        $chapterName = $chapter->chapterName;
        $chapterURL = $chapter->chapterURL;
        $type = $chapter->chapterType;
        $course = new Course();
        $course->setCourseID($courseID);
        $course->setChapterName($chapterName);
        $course->setType($type);
        $course->setChapterURL($chapterURL);
        $course->createChapter($sm->get('dbAdapter'));
        die(json_encode(array("status" => "succcess")));
    }


}

