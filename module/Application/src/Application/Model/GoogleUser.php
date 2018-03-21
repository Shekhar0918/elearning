<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class GoogleUser {

    private $name;
    private $emailID;
    private $gender;
    private $googleID;
    private $googleUserID;

    function __construct() {
        
    }

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

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGoogleID($googleID) {
        $this->googleID = $googleID;
    }

    public function getGoogleID() {
        return $this->googleID;
    }

    public function setGoogleUserID($googleUserID) {
        $this->googleUserID = $googleUserID;
    }

    public function getGoogleUserID() {
        return $this->googleUserID;
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
        $query = "select * from google_users where email=:email";
        $result = $eLearningDB->query($query)->execute(array("email" => $this->getEmailID()));
        if ($result->count()) {
            $googleUserID = $result->current()['id'];
            $query = "update google_users set name=:name where email=:email";
            $eLearningDB->query($query)->execute(array("name" => $this->getName(), "email" => $this->getEmailID()));
        } else {
            $query = "insert into google_users (name, email, gender) values (:name, :email, :gender)";
            $eLearningDB->query($query)->execute(array(
                "name" => $this->getName(),
                "email" => $this->getEmailID(),
                "gender" => $this->getGender()
            ));
            $googleUserID = $eLearningDB->getDriver()->getLastGeneratedValue("id");
        }
        return $googleUserID;
    }
    
    public function getGoogleUserInfoByGoogleUserID(Adapter $eLearningDB){
        $googleUserID = $this->getGoogleUserID();
        $query = "select * from google_users where id=:google_user_id";
        $result = $eLearningDB->query($query)->execute(array("google_user_id" => $googleUserID))->current();
        return $result;
    }

}
