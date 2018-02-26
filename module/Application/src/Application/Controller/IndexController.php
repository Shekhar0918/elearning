<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\MailerPhp;
use Zend\Session\Container;
use Application\Model\eLearningGoogle;
use Application\Model\eLearningFacebook;
use Application\Model\ELearningUser;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $user_session = new Container('elearning');
        if (isset($user_session->userID)) {
            $viewModel = new ViewModel();
            return $viewModel;
        } else {
            return $this->redirect()->toRoute('login');
        }
    }

    public function loginAction() {
        $this->layout('layout/login-layout');
        $viewModel = new ViewModel();
//        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function authAction() {
        if ($this->getRequest()->isPost()) {
            $user_session = new Container('elearning');
            $sm = $this->getServiceLocator();
            $email = $this->params()->fromPost('email');
            $source = $this->params()->fromPost('source');
            if ($source == "google") {
                $googleCredentials = $sm->get('Config')['googleCredentials'];
                $eLearningGoogle = new eLearningGoogle();
                $eLearningGoogle->setAPIKey($googleCredentials['apiKey']);
                $eLearningGoogle->setGoogleClientID($googleCredentials['clientID']);
                $eLearningGoogle->setClientSecret($googleCredentials['clientSecret']);
                $eLearningGoogle->setGoogleRedirectURL($googleCredentials['redirectURL']);
                $response = $eLearningGoogle->getGoogleAccessToken($sm->get('dbAdapter'));
//                die(json_encode($response));
//                return $this->redirect()->toRoute('home');
            }
            if ($source == "facebook") {
                $facebookCredentials = $sm->get('Config')['fbCredentials'];
                $eLearningfacebook = new eLearningFacebook();
                $eLearningfacebook->setAppID($facebookCredentials['app_id']);
                $eLearningfacebook->setAppSecret($facebookCredentials['app_secret']);
                $eLearningfacebook->setRedirectURL($facebookCredentials['redirect_uri']);
                $eLearningfacebook->loginFacebook($sm->get('dbAdapter'));
            }
            die("success");
        } else {
            return $this->redirect()->toRoute('login');
        }
    }

    public function googleAccessTokenAction() {
        $user_session = new Container('elearning');
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        $sm = $this->getServiceLocator();
        $googleCredentials = $sm->get('Config')['googleCredentials'];
        $googleCode = $this->params()->fromQuery('code');
        $eLearningGoogle = new eLearningGoogle();
        $eLearningGoogle->setAPIKey($googleCredentials['apiKey']);
        $eLearningGoogle->setGoogleClientID($googleCredentials['clientID']);
        $eLearningGoogle->setClientSecret($googleCredentials['clientSecret']);
        $eLearningGoogle->setGoogleRedirectURL($googleCredentials['redirectURL']);
        $eLearningGoogle->setGoogleCode($googleCode);
        $response = $eLearningGoogle->getGoogleAccessToken($sm->get('dbAdapter'));
        if ($response["status"] == "success") {
//            $viewModel->setVariables(array("status" => "success", "user_data" => $response["user_data"]));
            $user_session->userID = $response["user_data"]["email"];
            return $this->redirect()->toRoute('home');
//            die();
        } else {
            return $this->redirect()->toRoute('login');
//            $viewModel->setVariables(array("status" => "failed"));
//            die(json_encode(array("status" => "failed")));
        }
        return $viewModel;
    }

    public function facebookAccessTokenAction() {
         $user_session = new Container('elearning');
//        $viewModel = new ViewModel();
        $sm = $this->getServiceLocator();
        $fbCredentials = $sm->get('Config')['fbCredentials'];
        $eLearningFacebook = new eLearningFacebook();
        $eLearningFacebook->setAppID($fbCredentials['app_id']);
        $eLearningFacebook->setAppSecret($fbCredentials['app_secret']);
        $eLearningFacebook->setRedirectURL($fbCredentials['redirect_uri']);
        $response = $eLearningFacebook->getFacebookAccessToken($sm->get('dbAdapter'));
        $user_session->userID = $response['email'];
//        $viewModel->setVariables(array("output" => $response));
        try {
            return $this->redirect()->toRoute('home');
        } catch (\Exception $ex) {
            die("error=" . $ex->getMessage());
        }
//        return $viewModel;
    }

    public function logoutAction() {
        $user_session = new Container('elearning');
        $googleClient = new \Google_Client();
        $googleClient->revokeToken();
        $user_session->getManager()->getStorage()->clear('elearning');
        return $this->redirect()->toRoute('login');
    }

    public function getUserInfoAction() {
        $user_session = new Container('elearning');
        if (!isset($user_session->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'login')));
        }
        $userID = $user_session->userID;
        $sm = $this->getServiceLocator();
        $eLearningUser = new ELearningUser();
        $userInfo = $eLearningUser->getUserInfoByUSerID($sm->get('dbAdapter'), $userID);
        die(json_encode($userInfo));
    }

    public function sendMailAction() {
//        $emailDetails = $this->getRequest()->getParam('emailDetails');
        $recipients = array(
            (object) array("email" => "sshekhar@radiancesystems.com", "name" => "ShashiShekhar")
        );
        $emailDetails = json_encode((object) array('From' => 'sshekhar@radiancesystems.com', "FromName" => "Shashishekhar", "Recipients" => $recipients, "Subject" => "Test mail", "Body" => "This is a test mail.", "AltBody" => "EmailBody"));
        $emailDetails = json_decode($emailDetails);
        $mailer = new MailerPhp();
        $sendMail = $mailer->sendMail($emailDetails);
    }

}
