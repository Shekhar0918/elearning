<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class User {

    private $firstName;
    private $lastName;
    private $emailID;
    private $gender;
    private $accessType;
    private $loginSource;
    private $googleID;
    private $facebookID;
    private $userID;
    private $password;

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setEmailID($emailID) {
        $this->emailID = $emailID;
    }

    public function getEmailID() {
        return $this->emailID;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setAccessType($accessType) {
        $this->accessType = $accessType;
    }

    public function getAccessType() {
        return $this->accessType;
    }

    public function setLoginSource($loginSource) {
        $this->loginSource = $loginSource;
    }

    public function getLoginSource() {
        return $this->loginSource;
    }

    public function setGoogleID($googleID) {
        $this->googleID = $googleID;
    }

    public function getGoogleID() {
        return $this->googleID;
    }

    public function setFacebookID($facebookID) {
        $this->facebookID = $facebookID;
    }

    public function getFacebookID() {
        return $this->facebookID;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    function __construct() {
        
    }

    public function getUserInfoByUserID(Adapter $eLearningDB, $userID) {
        $query = "select * from users where id=:id";
//        print_r(array("id" => $userID));
        $result = $eLearningDB->query($query)->execute(array("id" => $userID));
        if ($result->count() > 0) {
            $result = $result->current();
            $userInfo = array(
                "userID" => $result['email'],
                "firstName" => $result['first_name'],
                "lastName" => $result['last_name'],
                "accessType" => $result['access_type'],
                "source" => $result['login_source']
            );
            $response = array("status" => "success", "userInfo" => $userInfo);
        } else {
            $response = array("status" => "failed");
        }
//        var_dump($response);
        return $response;
    }

    public function saveUserDetails(Adapter $eLearningDB) {
        $query = "insert into users (email,first_name,last_name,access_type,login_source,gender,google_id, facebook_id) values (:email,:first_name,:last_name,:access_type,:login_source,:gender,:google_id,:facebook_id)";
        $eLearningDB->query($query)->execute(array(
            "email" => $this->getEmailID(),
            "first_name" => $this->getFirstName(),
            "last_name" => $this->getLastName(),
            "access_type" => $this->getAccessType(),
            "login_source" => $this->getLoginSource(),
            "gender" => $this->getGender(),
            "google_id" => $this->getGoogleID(),
            "facebook_id" => $this->getFacebookID()
        ));
        $userID = $eLearningDB->getDriver()->getLastGeneratedValue();
        return $userID;
    }

    public static function isUserExist(Adapter $eLearningDB, $email) {
        $query = "select * from users where email=:email";
        $result = $eLearningDB->query($query)->execute(array("email" => $email));
        if ($result->count() > 0) {
            $resultObj = $result->current();
            $response = array("status" => TRUE, "userID" => $resultObj["id"]);
        } else {
            $response = array("status" => FALSE);
        }
        return $response;
    }

    public function saveSignUpDetails(Adapter $eLearningDB) {
        $encryptedPassword = !empty($this->getPassword()) ? md5($this->getPassword()) : "";
        $query = "update users set user_id=:user_id,password=:password,facebook_id=:facebook_id where email=:email";
        $result = $eLearningDB->query($query)->execute(array(
            "user_id" => $this->getUserID(),
            "password" => $encryptedPassword,
            "facebook_id" => $this->getFacebookID(),
            "email" => $this->getEmailID()
        ));
//        $userID = $eLearningDB->getDriver()->getLastGeneratedValue();
//        $userID = $eLearningDB->getDriver()->getLastGeneratedValue();
        $updated_row = $eLearningDB->query('select id from users where email=:email')->execute(array("email" => $this->getEmailID()))->current();
        $response = array("userID" => $updated_row['id']);
//        print_r($updated_row['id']);die("end");
        return $response;
    }

}
