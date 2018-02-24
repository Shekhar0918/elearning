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

class IndexController extends AbstractActionController {

    public function indexAction() {
//        $user_session = new Container('elearning');
//        if (isset($user_session->userID)) {
//            $viewModel = new ViewModel();
//            return $viewModel;
//        } else {
        return $this->redirect()->toRoute('login');
//        }
    }

    public function loginAction() {
        $this->layout('layout/login-layout');
        $viewModel = new ViewModel();
//        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function authAction() {
        if ($this->getRequest()->isPost()) {
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
                $authUrl = $eLearningGoogle->getGoogleAccessToken($sm->get('dbAdapter'));
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
            die("end 111");
        }
    }

    public function googleAccessTokenAction() {
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
            echo "<h1>You have login successfully <h1>";
            echo '<h3>Profile Details </h3>';
            echo "Email : " . $response['user_data']['email'] . "<br>";
            echo "Name : " . $response['user_data']['name'] . "<br>";
//            return $this->redirect()->toRoute('home');
            die();
        } else {
            die(json_encode(array("status" => "failed")));
        }
    }

    public function facebookAccessTokenAction() {
        $sm = $this->getServiceLocator();
        $fbCredentials = $sm->get('Config')['fbCredentials'];
        $eLearningFacebook = new eLearningFacebook();
        $eLearningFacebook->setAppID($fbCredentials['app_id']);
        $eLearningFacebook->setAppSecret($fbCredentials['app_secret']);
        $eLearningFacebook->setRedirectURL($fbCredentials['redirect_uri']);
        $eLearningFacebook->getFacebookAccessToken($sm->get('dbAdapter'));
    }

    public function logoutAction() {
        unset($_SESSION['token']);
        unset($_SESSION['userData']);

        //Reset OAuth access token
        $googleClient = new \Google_Client();
        $googleClient->revokeToken();

        //Destroy entire session
        session_destroy();

        //Redirect to homepage
        header("Location:login");
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
