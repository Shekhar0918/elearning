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
    private $googleUserID;
    private $facebookUserID;
    
    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }
    public function getFirstName(){
        return $this->firstName;
    }
    public function setLastName($lastName){
        $this->lastName = $lastName;
    }
    public function getLastName(){
        return $this->lastName;
    }
    public function setEmailID($emailID){
        $this->emailID = $emailID;
    }
    public function getEmailID(){
        return $this->emailID;
    }
    public function setGender($gender){
        $this->gender = $gender;
    }
    public function getGender(){
        return $this->gender;
    }  
    public function setAccessType($accessType){
        $this->accessType = $accessType;
    }
    public function getAccessType(){
        return $this->accessType;
    }  
    public function setLoginSource($loginSource){
        $this->loginSource = $loginSource;
    }
    public function getLoginSource(){
        return $this->loginSource;
    }   
    
    public function setGoogleUserID($googleUserID) {
        $this->googleUserID = $googleUserID;
    }

    public function getGoogleUserID() {
        return $this->googleUserID;
    }

    public function setFacebookUserID($facebookUserID) {
        $this->facebookUserID = $facebookUserID;
    }

    public function getFacebookUserID() {
        return $this->facebookUserID;
    }  
    
    function __construct() {
        
    }
    
    public function getUserInfoByUSerID(Adapter $eLearningDB, $userID){
        $query = "select * from users where email=:email";
        $result = $eLearningDB->query($query)->execute(array("email"=>$userID))->current();
        $userInfo = array(
            "userID" => $result['email'],
            "firstName" => $result['first_name'],
            "lastName" => $result['last_name'],
            "accessType" => $result['access_type'],
            "source" => $result['login_source']
        );
        return $userInfo;
    }
    
    public function saveUserDetails(Adapter $eLearningDB){
        $query = "insert into users (email,first_name,last_name,access_type,login_source,gender,google_user_id, facebook_user_id) values (:email,:first_name,:last_name,:access_type,:login_source,:gender,:google_user_id,:facebook_user_id)";
//        print_r(array(
//            "email" => $this->getEmailID(),
//            "first_name" => $this->getFirstName(),
//            "last_name" => $this->getLastName(),
//            "access_type" => $this->getAccessType(),
//            "login_source" => $this->getLoginSource(),
//            "gender" => $this->getGender(),
//            "google_user_id" => $this->getGoogleUserID(),
//            "facebook_user_id" => $this->getFacebookUserID()
//        ));die();
        $eLearningDB->query($query)->execute(array(
            "email" => $this->getEmailID(),
            "first_name" => $this->getFirstName(),
            "last_name" => $this->getLastName(),
            "access_type" => $this->getAccessType(),
            "login_source" => $this->getLoginSource(),
            "gender" => $this->getGender(),
            "google_user_id" => $this->getGoogleUserID(),
            "facebook_user_id" => $this->getFacebookUserID()
        ));
    }
    
}
