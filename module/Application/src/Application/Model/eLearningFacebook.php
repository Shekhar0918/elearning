<?php

namespace Application\Model;

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class eLearningFacebook {

    private $appID;
    private $appSecret;
    private $redirectURL;

    function __construct() {
        
    }

    public function setAppID($appID) {
        $this->appID = $appID;
    }

    public function getAppID() {
        return $this->appID;
    }

    public function setAppSecret($appSecret) {
        $this->appSecret = $appSecret;
    }

    public function getAppSecret() {
        return $this->appSecret;
    }

    public function setRedirectURL($redirectURL) {
        $this->redirectURL = $redirectURL;
    }

    public function getRedirectURL() {
        return $this->redirectURL;
    }

    function loginFacebook(Adapter $eLearningDB) {
        $appID = $this->getAppID();
        $appSecret = $this->getAppSecret();
        $redirectURL = $this->getRedirectURL();
//        echo "appID = " .$appID . "\n";
//        echo "appSecret = " .$appSecret . "\n";
//        echo "redirectURL = " .$redirectURL . "\n";die();

        $fb = new Facebook(array(
            'app_id' => $appID,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.2',
        ));

        $helper = $fb->getRedirectLoginHelper();
        $permissions = array('email'); // Optional permissions
        $loginUrl = $helper->getLoginUrl($redirectURL, $permissions);
        header('Location: ' . $loginUrl);
        die('');
    }

    function getFacebookAccessToken(Adapter $eLearningDB) {
        $appID = $this->getAppID();
        $appSecret = $this->getAppSecret();
        $redirectURL = $this->getRedirectURL();
        $fb = new Facebook(array(
            'app_id' => $appID,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.2',
        ));

// Get redirect login helper
        $helper = $fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }

// Try to get access token
        try {
            if (isset($_SESSION['facebook_access_token'])) {
                $accessToken = $_SESSION['facebook_access_token'];
            } else {
                $accessToken = $helper->getAccessToken();
            }
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
//        echo '<h3>Access Token</h3>';
//        var_dump($accessToken->getValue());
        $fb->setDefaultAccessToken($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
//        echo '<h3>Metadata</h3>';
//        var_dump($tokenMetadata);
        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId($appID); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }

//            echo '<h3>Long-lived</h3>';
//            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        // Getting user facebook profile info
        try {
            $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
            $fbUserProfile = $profileRequest->getGraphNode()->asArray();
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // Redirect user back to app login page
            header("Location: http://localhost/elearning/public/login");
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $fbUserData = array(
            'oauth_provider' => 'facebook',
            'oauth_uid' => $fbUserProfile['id'],
            'first_name' => $fbUserProfile['first_name'],
            'last_name' => $fbUserProfile['last_name'],
            'email' => $fbUserProfile['email'],
            'gender' => $fbUserProfile['gender'],
            'locale' => $fbUserProfile['locale'],
            'picture' => $fbUserProfile['picture']['url'],
            'link' => $fbUserProfile['link']
        );
//        echo json_encode($fbUserData);
        $query = "select * from users where email=:email and login_source='facebook'";
        $count = $eLearningDB->query($query)->execute(array("email" => $fbUserProfile['email']))->count();
        if ($count <= 0) {
            $user_query = "insert into users (email, first_name, last_name, access_type, login_source) values (:email, :first_name, :last_name, :access_type, :login_source)";
            $eLearningDB->query($user_query)->execute(array(
                "email" => $fbUserProfile['email'],
                "first_name" => $fbUserProfile['first_name'],
                "last_name" => $fbUserProfile['last_name'],
                "access_type" => "student",
                "login_source" => "facebook"
            ));
        }
        $output =  "<h1>You have login successfully <h1>";
        $output .= '<h3>Profile Details </h3>';
        $output .= '<img src="' . $fbUserData['picture'] . '">';
        $output .= '<br/>Facebook ID : ' . $fbUserData['oauth_uid'];
        $output .= '<br/>Name : ' . $fbUserData['first_name'] . ' ' . $fbUserData['last_name'];
        $output .= '<br/>Email : ' . $fbUserData['email'];
        $output .= '<br/>Gender : ' . $fbUserData['gender'];
//        $output .= '<br/>Locale : ' . $fbUserData['locale'];
        $output .= '<br/>Logged in with : Facebook';
        $output .= '<br/><a href="' . $fbUserData['link'] . '" target="_blank">Click to Visit Facebook Page</a>';
//        $output .= '<br/>Logout from <a href="' . $logoutURL . '">Facebook</a>';
//        return $output;
        die($output);
        return $fbUserData;
//        die($output);
    }

}
