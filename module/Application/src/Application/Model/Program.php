<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class Program {
    private $enrollementID;
    private $enrolledProgramID;
    private $enrolledProgram;
    
    function __construct() {
        
    }
    
    public function setEnrollmentID($enrollementID){
        $this->enrollementID = $enrollementID;
    }
    public function getEnrollmentID(){
        return $this->enrollementID;
    }
    public function setEnrolledProgramID($enrolledProgramID){
        $this->enrolledProgramID = $enrolledProgramID;
    }
    public function getEnrolledProgramID(){
        return $this->enrolledProgramID;
    }
    public function setEnrolledProgram($enrolledProgram){
        $this->enrolledProgram = $enrolledProgram;
    }
    public function getEnrolledProgram(){
        return $this->enrolledProgram;
    }
    
    public function getEnrolledProgramsByUserID(Adapter $eLearningDB, $userID){
//        $query = "select * from enrolled_programs where user_id=:user_id";
//        $result = $eLearningDB->query($query)->execute(array("user_id" => $userID));
//        $enrolledPrograms = array();
//        foreach($result as $resultRow){
//            array_push($enrolledPrograms, array(
////                "id" => $resultRow['id'], 
//                "program_id" => $resultRow['program_id'], 
//                "program_name" => $resultRow['program_name']
//                    ) );
//        }
//        return $enrolledPrograms;
        
//        $query = "select * from programs where program_id in (select DISTINCT program_id from enrolled_programs where user_id=:user_id)";
        $query = "select * from programs where program_id in (select DISTINCT program_id from enrolled_programs)";
        $result = $eLearningDB->query($query)->execute(array("user_id" => $userID));
        $enrolledPrograms = array();
        foreach($result as $resultRow){
            array_push($enrolledPrograms, array(
//                "id" => $resultRow['id'], 
                "program_id" => $resultRow['program_id'], 
                "program_name" => $resultRow['program_name'],
                "chapters" =>  json_decode($resultRow['chapters']),
                    ) );
        }
        return $enrolledPrograms;
    }
}
