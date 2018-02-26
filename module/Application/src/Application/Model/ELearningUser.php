<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class ELearningUser {
    private $firstName;
    private $lastName;
    private $userID;
    private $emailID;
    
    
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
    
}
