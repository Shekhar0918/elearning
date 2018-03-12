<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class FacebookUser {

    private $name;
    private $emailID;
    private $gender;
    private $facebookID;
    private $facebookUserID;

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
            $query = "update facebook_users set name=:name where email=:email";
            $eLearningDB->query($query)->execute(array("name"=>$this->getName(), "email" => $this->getEmailID()));
        } else {
            $query = "insert into facebook_users (facebook_id, name, email, gender) values (:facebook_id, :name, :email, :gender)";
            $eLearningDB->query($query)->execute(array(
                "facebook_id" => $this->getFacebookID(),
                "name" => $this->getName(),
                "email" => $this->getEmailID(),
                "gender" => $this->getGender()
            ));
            $facebookUserID = $eLearningDB->getDriver()->getLastGeneratedValue("id");
        }
        return $facebookUserID;
    }

}
