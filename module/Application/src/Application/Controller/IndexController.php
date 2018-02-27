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
use Application\Model\GoogleAuthentication;
use Application\Model\FacebookAuthentication;
use Application\Model\User;
use Application\Model\GoogleUser;
use Application\Model\FacebookUser;

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
                $googleAuthentication = new GoogleAuthentication();
                $googleAuthentication->setAPIKey($googleCredentials['apiKey']);
                $googleAuthentication->setGoogleClientID($googleCredentials['clientID']);
                $googleAuthentication->setClientSecret($googleCredentials['clientSecret']);
                $googleAuthentication->setGoogleRedirectURL($googleCredentials['redirectURL']);
                $response = $googleAuthentication->getGoogleAccessToken($sm->get('dbAdapter'));
            }
            if ($source == "facebook") {
                $facebookCredentials = $sm->get('Config')['fbCredentials'];
                $facebookAuthentication = new FacebookAuthentication();
                $facebookAuthentication->setAppID($facebookCredentials['app_id']);
                $facebookAuthentication->setAppSecret($facebookCredentials['app_secret']);
                $facebookAuthentication->setRedirectURL($facebookCredentials['redirect_uri']);
                $facebookAuthentication->loginFacebook($sm->get('dbAdapter'));
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
        $googleAuthentication = new GoogleAuthentication();
        $googleAuthentication->setAPIKey($googleCredentials['apiKey']);
        $googleAuthentication->setGoogleClientID($googleCredentials['clientID']);
        $googleAuthentication->setClientSecret($googleCredentials['clientSecret']);
        $googleAuthentication->setGoogleRedirectURL($googleCredentials['redirectURL']);
        $googleAuthentication->setGoogleCode($googleCode);
        $response = $googleAuthentication->getGoogleAccessToken($sm->get('dbAdapter'));
        if ($response["status"] == "success") {
            $userDetails = $response['userDetails'];
//            $viewModel->setVariables(array("status" => "success", "user_data" => $response["user_data"]));
            $user_session->userID = $response["userDetails"]["email"];
            $isGoogleUserExist = GoogleUser::isGoogleUserExist($sm->get('dbAdapter'), $userDetails["email"]);
            if($isGoogleUserExist){                
                return $this->redirect()->toRoute('home');
            }else{
                $googleUsers = new GoogleUser();
                $googleUsers->setFirstName($userDetails['firstName']);
                $googleUsers->setLastName($userDetails['lastName']);
                $googleUsers->setEmailID($userDetails['email']);
                $googleUsers->setGender($userDetails['gender']);
                $googleUserID = $googleUsers->saveGoogleUserDetails($sm->get('dbAdapter'));
                
                $users = new User();
                $users->setFirstName($userDetails['firstName']);
                $users->setLastName($userDetails['lastName']);
                $users->setEmailID($userDetails['email']);
                $users->setGender($userDetails['gender']);
                $users->setLoginSource("google");
                $users->setAccessType("student");
                $users->setGoogleUserID($googleUserID);
                $users->saveUserDetails($sm->get('dbAdapter'));
                return $this->redirect()->toRoute('home');
            }
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
        $facebookAuthentication = new FacebookAuthentication();
        $facebookAuthentication->setAppID($fbCredentials['app_id']);
        $facebookAuthentication->setAppSecret($fbCredentials['app_secret']);
        $facebookAuthentication->setRedirectURL($fbCredentials['redirect_uri']);
        $response = $facebookAuthentication->getFacebookAccessToken($sm->get('dbAdapter'));
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
        $user = new User();
        $userInfo = $user->getUserInfoByUSerID($sm->get('dbAdapter'), $userID);
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
