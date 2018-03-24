<?php

namespace Admin\Model;

use Zend\Db\Adapter\Adapter;

class AdminUser {
    
    private $adminUserID;
    private $adminEmailID;
    
    
    function __construct() {
        
    }
    
    public function setAdminUserID($adminUserID){
        $this->adminUserID = $adminUserID;
    }
    
    public function getAdminUserID(){
        return $this->adminUserID;
    }
    
    public function setAdminEmailID($adminEmailID){
        $this->adminEmailID = $adminEmailID;
    }
    
    public function getAdminEmailID(){
        return $this->adminEmailID;
    }
    
    public function login(Adapter $eLearningDB, $userEmailID, $password){
        $encryptedPassword = md5($password);
        $query = "select * from users where email=:email and access_type='admin'";
//        var_dump(array("email" => $userEmailID));die();
        $adminUser = $eLearningDB->query($query)->execute(array("email" => $userEmailID))->current();
        $dbEmailID = $adminUser["email"];
        if($dbEmailID == $userEmailID){
            $dbPwd = $adminUser['password'];
            if ($dbPwd == $encryptedPassword) {
                $this->adminEmailID = $adminUser['email'];
                $this->adminUserID = $adminUser['id'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function getAdminUserInfoByUserID(Adapter $eLearningDB){
        $adminUserID = $this->getAdminUserID();
        $query = "select * from users where id=:admin_user_id";
        $adminUser = $eLearningDB->query($query)->execute(array("admin_user_id" => $adminUserID))->current();
        $adminUSerInfo['email'] = $adminUser['email'];
        $adminUSerInfo['name'] = $adminUser['name'];
        $adminUSerInfo['access_type'] = $adminUser['access_type'];
        return $adminUSerInfo;
    }
}