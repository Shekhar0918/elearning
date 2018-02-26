<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class eLearningGoogle {

    private $apiKey;
    private $googleClientID;
    private $clientSecret;
    private $googleRedirectURL;
    private $googleCode;

    function __construct() {
        
    }

    public function setAPIKey($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function getAPIKey() {
        return $this->apiKey;
    }

    public function setGoogleClientID($googleClientID) {
        $this->googleClientID = $googleClientID;
    }

    public function getGoogleClientID() {
        return $this->googleClientID;
    }

    public function setClientSecret($clientSecret) {
        $this->clientSecret = $clientSecret;
    }

    public function getClientSecret() {
        return $this->clientSecret;
    }

    public function setGoogleRedirectURL($googleRedirectURL) {
        $this->googleRedirectURL = $googleRedirectURL;
    }

    public function getGoogleRedirectURL() {
        return $this->googleRedirectURL;
    }

    public function setGoogleCode($googleCode) {
        $this->googleCode = $googleCode;
    }

    public function getGoogleCode() {
        return $this->googleCode;
    }

    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken() {
        return $this->accessToken;
    }

    function getGoogleAccessToken(Adapter $eLearningDB) {
        try {
            $apiKey = $this->getAPIKey();
            $googleClientID = $this->getGoogleClientID();
            $clientSecret = $this->getClientSecret();
            $googleRedirectURL = $this->getGoogleRedirectURL();
            $googleCode = $this->getGoogleCode();

            $googleClient = new \Google_Client();
            $googleClient->setClientId($googleClientID);
            $googleClient->setClientSecret($clientSecret);
            $googleClient->setRedirectUri($googleRedirectURL);
            $googleClient->addScope("email");
            $googleClient->addScope("profile");
            if (!isset($googleCode)) {
                $auth_url = $googleClient->createAuthUrl();
                header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
                die('');
            } else {
                $result = $googleClient->authenticate($googleCode);
                $service = new \Google_Service_Oauth2($googleClient);
                $user = $service->userinfo->get();
//                echo "<h1>You have login successfully <h1>";
//                echo '<h3>Profile Details </h3>';
//                echo "Email : " . $user['email'] . "<br>";
//                echo "Name : " . $user['name'] . "<br>";
                $count = $eLearningDB->query("select * from users where email=:email")->execute(array("email" => $user['email']))->count();
                if ($count <= 0) {
                    $user_query = "insert into users (email, first_name, last_name, access_type, login_source) values (:email, :first_name, :last_name, :access_type, :login_source)";
                    $eLearningDB->query($user_query)->execute(array(
                        "email" => $user['email'],
                        "first_name" => $user['givenName'],
                        "last_name" => $user['familyName'],
                        "access_type" => "student",
                        "login_source" => "google"
                    ));
                }
                $user_data = array(
                    "email" => $user['email'],
                    "name" => $user['name'],
                    "first_name" => $user['givenName'],
                    "last_name" => $user['familyName']
                );
//                $_SESSION['userID'] = $user['email'];
                return $response = array("status" => "success", "user_data" => $user_data);
            }
        } catch (\Exception $ex) {
            die("Error: " . $ex->getMessage());
        }
    }

}
