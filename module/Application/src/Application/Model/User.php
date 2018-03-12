<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
;

use Application\Model\GoogleUser;
use Application\Model\FacebookUser;

class User {

    private $name;
    private $emailID;
    private $designation;
    private $city;
    private $country;
    private $phone;
    private $businessEmail;
    private $loginSource;
    private $accessType;

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setEmailID($emailID) {
        $this->emailID = $emailID;
    }

    public function getEmailID() {
        return $this->emailID;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
    }

    public function getDesignation() {
        return $this->designation;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setBusinessEmail($businessEmail) {
        $this->businessEmail = $businessEmail;
    }

    public function getBusinessEmail() {
        return $this->businessEmail;
    }

    public function setLoginSource($loginSource) {
        $this->loginSource = $loginSource;
    }

    public function getLoginSource() {
        return $this->loginSource;
    }

    public function setAccessType($accessType) {
        $this->accessType = $accessType;
    }

    public function getAccessType() {
        return $this->accessType;
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
                "email" => $result['email'],
                "name" => $result['name'],
                "designation" => $result['designation'],
                "organization" => $result['organization'],
                "city" => $result['city'],
                "country" => $result['country'],
                "phone" => $result['phone'],
                "business_email" => $result['business_email']
            );
            $response = array("status" => "success", "userInfo" => $userInfo);
        } else {
            $response = array("status" => "failed");
        }
//        var_dump($response);
        return $response;
    }

    public function saveUserDetails(Adapter $eLearningDB, $googleUsers, $faceboolUsers) {
        $query = "select * from users where email=:email";
        $result = $eLearningDB->query($query)->execute(array("email" => $this->getEmailID()));
        if ($result->count() > 0) {
            $userID = $result->current()['id'];
            if (empty($this->getGoogleID())) {
                $update_query = "update users set facebook_user_id = :facebook_user_id where email=:email";
                $eLearningDB->query($update_query)->execute(array("facebook_user_id" => $faceboolUsers->getFacebookUserID(), "email" => $this->getEmailID()));
            } else {
                $update_query = "update users set google_user_id = :google_user_id where email=:email";
                $eLearningDB->query($update_query)->execute(array("google_user_id" => $googleUsers->getGoogleUserID(), "email" => $this->getEmailID()));
            }
        } else {
            $query = "insert into users (email,name,access_type,login_source,google_user_id, facebook_user_id) values (:email,:name,:access_type,:login_source,:google_user_id,:facebook_user_id)";
            $eLearningDB->query($query)->execute(array(
                "email" => $this->getEmailID(),
                "name" => $this->getName(),
                "access_type" => $this->getAccessType(),
                "login_source" => $this->getLoginSource(),
                "google_user_id" => $googleUsers->getGoogleUserID(),
                "facebook_user_id" => $faceboolUsers->getFacebookUserID()
            ));
            $userID = $eLearningDB->getDriver()->getLastGeneratedValue();
        }
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

    public function saveSignUpDetails(Adapter $eLearningDB, $googleUser, $facebookUser) {
//        $encryptedPassword = !empty($this->getPassword()) ? md5($this->getPassword()) : "";
        try{
        $result = $eLearningDB->query("select * from users where email=:email")->execute(array("email" => $this->getEmailID()));
        if ($result->count() > 0) {
            $userResult = $result->current();
            $userID = $userResult['id'];
            $loginSource = $this->getLoginSource();
            if ($loginSource == "google") {
//                $facbookUser = new FacebookUser();
//                $facbookUser->setFacebookID($this->getFacebookID());
                $facebookUser->setEmailID($this->getEmailID());
                $facebookUserID = $facebookUser->saveFacebookUserDetails($eLearningDB);
                $query = "update users set name=:name,designation=:designation,city=:city,country=:country,phone=:phone,business_email=:business_email,facebook_user_id=:facebook_user_id where email=:email";
                $eLearningDB->query($query)->execute(array(
                    "name" => $this->getName(),
                    "designation" => $this->getDesignation(),
                    "city" => $this->getCity(),
                    "country" => $this->getCountry(),
                    "phone" => $this->getPhone(),
                    "business_email" => $this->getBusinessEmail(),
                    "facebook_user_id" => $facebookUserID,
                    "email" => $this->getEmailID()
                ));
            } else {
//                $googleUser = new GoogleUser();
//                $googleUser->setGoogleID($this->getGoogleID());
                $googleUser->setEmailID($this->getEmailID());
                $gacebookUserID = $googleUser->saveGoogleUserDetails($eLearningDB);
                $query = "update users set name=:name,designation=:designation,city=:city,country=:country,phone=:phone,business_email=:business_email,google_user_id=:google_user_id where email=:email";
                $eLearningDB->query($query)->execute(array(
                    "name" => $this->getName(),
                    "designation" => $this->getDesignation(),
                    "city" => $this->getCity(),
                    "country" => $this->getCountry(),
                    "phone" => $this->getPhone(),
                    "business_email" => $this->getBusinessEmail(),
                    "google_user_id" => $gacebookUserID,
                    "email" => $this->getEmailID()
                ));
            }
        } else {
            $query = "insert into users (email,name,designation,city,country,phone,business_email,access_type,login_source,google_user_id,facebook_user_id) values (:email,:name,:designation,:city,:country,:phone,:business_email,:access_type,:login_source,:google_user_id,:facebook_user_id)";
            $eLearningDB->query($query)->execute(array(
                "email" => $this->getEmailID(),
                "name" => $this->getName(),
                "designation" => $this->getDesignation(),
                "city" => $this->getCity(),
                "country" => $this->getCountry(),
                "phone" => $this->getPhone(),
                "business_email" => $this->getBusinessEmail(),
                "access_type" => $this->getAccessType(),
                "login_source" => $this->getLoginSource(),
                "google_user_id" => $facebookUser->getFacebookUserID(),
                "facebook_user_id" => $facebookUser->getFacebookUserID()
            ));
            $userID = $eLearningDB->getDriver()->getLastGeneratedValue();
        }
        $response = array("userID" => $userID);
//        die("user_id=".$userID);
        return $response;
        }  catch (\Exception $ex){
            die($ex->getMessage());
        }
    }

}
