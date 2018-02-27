<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class GoogleUser {

    private $firstName;
    private $lastName;
    private $emailID;
    private $gender;

    function __construct() {
        
    }

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
    
    public function setGoogleUserID($googleUserID) {
        $this->googleUserID = $googleUserID;
    }

    public function getGoogleUserID() {
        return $this->googleUserID;
    }

    public function setFacebokUserID($facebookUserID) {
        $this->facebookUserID = $facebookUserID;
    }

    public function getFacebokUserID() {
        return $this->facebookUserID;
    }
    
    public static function isGoogleUserExist(Adapter $eLearningDB, $email) {
        $query = "select * from google_users where email=:email";
        $count = $eLearningDB->query($query)->execute(array("email" => $email))->count();
        if ($count > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function saveGoogleUserDetails(Adapter $eLearningDB) {
        $query = "insert into google_users (first_name, last_name, email, gender) values (:first_name, :last_name, :email, :gender)";
        $eLearningDB->query($query)->execute(array(
            "first_name" => $this->getFirstName(),
            "last_name" => $this->getLastName(),
            "email" => $this->getEmailID(),
            "gender" => $this->getGender()
        ));
        $googleUserID = $eLearningDB->getDriver()->getLastGeneratedValue("id");
        return $googleUserID;
    }

}
