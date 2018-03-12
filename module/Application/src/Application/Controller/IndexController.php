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
use Application\Model\Program;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $userSession = new Container('eLearning');
        if (isset($userSession->userID)) {
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
            $user_session = new Container('eLearning');
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
        $userSession = new Container('eLearning');
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
        if ($response["status"] == TRUE) {
            $userDetails = $response['userDetails'];
//            $viewModel->setVariables(array("status" => "success", "user_data" => $response["user_data"]));
            $userSession->emailID = $response["userDetails"]["email"];
//            $isGoogleUserExist = GoogleUser::isGoogleUserExist($sm->get('dbAdapter'), $userDetails["email"]);
            $isUserExist = User::isUserExist($sm->get('dbAdapter'), $userDetails["email"]);
            if ($isUserExist["status"]) {
//                die("exist");
//                var_dump($isUserExist);die();
                $userSession->userID = $isUserExist['userID'];
                return $this->redirect()->toRoute('home');
            } else {
//                die("not exist");
//                print_r($userDetails);die();
                $googleUsers = new GoogleUser();
                $googleUsers->setName($userDetails['name']);
                $googleUsers->setEmailID($userDetails['email']);
                $googleUserID = $googleUsers->saveGoogleUserDetails($sm->get('dbAdapter'));
                $googleUsers->setGoogleUserID($googleUserID);

                $user = new User();
//                $users->setName($userDetails['name']);
//                $users->setLastName($userDetails['lastName']);
//                $users->setEmailID($userDetails['email']);
//                $users->setGender($userDetails['gender']);
//                $users->setLoginSource("google");
//                $users->setAccessType("student");

                $user->setName($userDetails['name']);
                $user->setEmailID($userDetails['email']);
//                $user->setDesignation($userDetails['designation']);
//                $user->setCity($userDetails['city']);
//                $user->setCountry($userDetails['country']);
//                $user->setPhone($userDetails['phone']);
//                $user->setBusinessEmail($userDetails['business_email']);
                $user->setLoginSource("google");
                $user->setAccessType("student");


//                $users->setGoogleID($googleUserID);
                $facebookUser = new FacebookUser();
                $userID = $user->saveUserDetails($sm->get('dbAdapter'), $googleUsers, $facebookUser);
//                $userSession->userID = $userID;
                return $this->redirect()->toRoute('googleSignup');
//                return $this->redirect()->toRoute('home');
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
        $userSession = new Container('eLearning');
//        $viewModel = new ViewModel();
        $sm = $this->getServiceLocator();
        $fbCredentials = $sm->get('Config')['fbCredentials'];
        $facebookAuthentication = new FacebookAuthentication();
        $facebookAuthentication->setAppID($fbCredentials['app_id']);
        $facebookAuthentication->setAppSecret($fbCredentials['app_secret']);
        $facebookAuthentication->setRedirectURL($fbCredentials['redirect_uri']);
        $response = $facebookAuthentication->getFacebookAccessToken($sm->get('dbAdapter'));
        if ($response["status"] == TRUE) {
            $userDetails = $response['userDetails'];
//            $viewModel->setVariables(array("status" => "success", "user_data" => $response["user_data"]));
            $userSession->emailID = $response["userDetails"]["email"];
            $isFacebookUserExist = FacebookUser::isFacebookUserExist($sm->get('dbAdapter'), $userDetails["email"]);
            $isUserExist = User::isUserExist($sm->get('dbAdapter'), $userDetails["email"]);
            if ($isUserExist["status"] && $isFacebookUserExist) {
//                die("exist");
                $userSession->userID = $isUserExist['userID'];
                return $this->redirect()->toRoute('home');
            } else {
//                die("notexist");
                $facebookUser = new FacebookUser();
                $facebookUser->setName($userDetails['firstName'] . " " . $userDetails['lastName']);
                $facebookUser->setEmailID($userDetails['email']);
                $facebookUserID = $facebookUser->saveFacebookUserDetails($sm->get('dbAdapter'));
                $facebookUser->setFacebookUserID($facebookUserID);

                $user = new User();
                $user->setName($userDetails['firstName'] . " " . $userDetails['lastName']);
                $user->setEmailID($userDetails['email']);
//                $user->setGender($userDetails['gender']);
                $user->setLoginSource("facebook");
                $user->setAccessType("student");
//                $users->setFacebookID($facebookUserID);
                $googleUser = new GoogleUser();
                $userID = $user->saveUserDetails($sm->get('dbAdapter'), $googleUser, $facebookUser);
                return $this->redirect()->toRoute('facebookSignup');
            }
        } else {
            return $this->redirect()->toRoute('login');
        }
    }

    public function signupAction() {
        $viewModel = new ViewModel();
//        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function facebookSignupAction() {
        $viewModel = new ViewModel();
//        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function googleSignupAction() {
        $viewModel = new ViewModel();
//        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function userSignUpAction() {
        $userSession = new Container('eLearning');
        $emailID = $userSession->emailID;
        $sm = $this->getServiceLocator();
        $name = $this->params()->fromPost('user_name');
        $userDesignation = $this->params()->fromPost('user_designation');
        $userOrganization = $this->params()->fromPost('user_organization');
        $userCity = $this->params()->fromPost('user_city');
        $userCountry = $this->params()->fromPost('user_country');
        $userPhone = $this->params()->fromPost('user_phone');
        $businessEmail = $this->params()->fromPost('business_email');
        $googleID = $this->params()->fromPost('google_id');
        $facebookID = $this->params()->fromPost('facebook_id');
        $loginSource = $this->params()->fromPost('login_source');


//        echo $emailID . " === " . $userID . "====" . $userPassword . "====" . $facebookID;die("end");
        $user = new User();
        $user->setName($name);
        $user->setEmailID($emailID);
        $user->setDesignation($userDesignation);
        $user->setOrganization($userOrganization);
        $user->setCity($userCity);
        $user->setCountry($userCountry);
        $user->setPhone($userPhone);
        $user->setBusinessEmail($businessEmail);
        $user->setLoginSource($loginSource);
        $googleUser = new GoogleUser();
        $googleUser->setGoogleUserID($googleID);
        $facebookUser = new FacebookUser();
        $facebookUser->setFacebookUserID($facebookID);
        $response = $user->saveSignUpDetails($sm->get('dbAdapter'), $googleUser, $facebookUser);
        $googleAuthentication = new GoogleAuthentication();
//        $googleAuthentication->sendVerificationMail($sm->get('dbAdapter'), $user);
        $userSession->userID = $response['userID'];
        return $this->redirect()->toRoute('home');


////        $user->setFacebookID($facebookID);
////        $user->setGoogleID($googleID);
//        $user->setEmailID($emailID);
//        $user->setLoginSource($loginSource);
//        $googleUser = new GoogleUser();
//        $googleUser->setGoogleUserID($googleID);
//        $facebookUser = new FacebookUser();
//        $facebookUser->setFacebookUserID($facebookID);
//        $response = $user->saveSignUpDetails($sm->get('dbAdapter'), $googleUser, $facebookUser);
//        $userSession->userID = $response['userID'];
////        var_dump("userSignUpAction=".$userSession->userID);die();
////        die("Email ID = " . $emailID . "userID = " . $response['userID']);
//        return $this->redirect()->toRoute('home');
    }

    public function logoutAction() {
        $user_session = new Container('eLearning');
        $googleClient = new \Google_Client();
        $googleClient->revokeToken();
        $user_session->getManager()->getStorage()->clear('eLearning');
        return $this->redirect()->toRoute('login');
    }

    public function getUserInfoAction() {
        $userSession = new Container('eLearning');
//        var_dump("getUserInfoAction=".$userSession->userID);die("end");
        if (!isset($userSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'login')));
        }
        $userID = $userSession->userID;
        $sm = $this->getServiceLocator();
        $user = new User();
        $userInfo = $user->getUserInfoByUserID($sm->get('dbAdapter'), $userID);
        die(json_encode($userInfo));
    }

    public function getEnrolledProgramsAction() {
        $userSession = new Container('eLearning');
        if (!isset($userSession->userID)) {
            die(json_encode(array('status' => false, 'statusCode' => 'notAuthorised', 'url' => 'login')));
        }
        $userID = $userSession->userID;
        $sm = $this->getServiceLocator();
        $program = new Program();
        $enrolledProgramList = $program->getEnrolledProgramsByUserID($sm->get('dbAdapter'), $userID);
        die(json_encode($enrolledProgramList));
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
