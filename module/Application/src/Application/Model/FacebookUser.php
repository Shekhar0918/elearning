<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class FacebookUser {

    private $firstName;
    private $lastName;
    private $emailID;
    private $gender;
    private $facebookID;
    private $facebookUserID;

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

    public function setFacebookID($facebookID) {
        $this->facebookID = $facebookID;
    }

    public function getFacebookID() {
        return $this->facebookID;
    }

    public function setFacebookUserID($facebookUserID) {
        $this->facebookUserID = $facebookUserID;
    }

    public function getFacebookUserID() {
        return $this->facebookUserID;
    }

    public static function isFacebookUserExist(Adapter $eLearningDB, $email) {
        $query = "select * from facebook_users where email=:email";
        $count = $eLearningDB->query($query)->execute(array("email" => $email))->count();
        if ($count > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function saveFacebookUserDetails(Adapter $eLearningDB) {
        $query = "select * from facebook_users where email=:email";
        $result = $eLearningDB->query($query)->execute(array("email" => $this->getEmailID()));
        if ($result->count()) {
            $facebookUserID = $result->current()['id'];
            $query = "update facebook_users set first_name=:first_name, last_name=:last_name where email=:email";
            $eLearningDB->query($query)->execute(array("first_name"=>$this->getFirstName(), "last_nmae" => $this->getLastName(), "email" => $this->getEmailID()));
        } else {
            $query = "insert into facebook_users (facebook_id, first_name, last_name, email, gender) values (:facebook_id, :first_name, :last_name, :email, :gender)";
            $eLearningDB->query($query)->execute(array(
                "facebook_id" => $this->getFacebookID(),
                "first_name" => $this->getFirstName(),
                "last_name" => $this->getLastName(),
                "email" => $this->getEmailID(),
                "gender" => $this->getGender()
            ));
            $facebookUserID = $eLearningDB->getDriver()->getLastGeneratedValue("id");
        }
        return $facebookUserID;
    }

}
