<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class Program {

    private $programID;
    private $enrollementID;
    private $enrolledProgramID;
    private $enrolledProgram;

    function __construct() {
        
    }

    public function setProgramID($programID) {
        $this->programID = $programID;
    }

    public function getProgramID() {
        return $this->programID;
    }

    public function setEnrollmentID($enrollementID) {
        $this->enrollementID = $enrollementID;
    }

    public function getEnrollmentID() {
        return $this->enrollementID;
    }

    public function setEnrolledProgramID($enrolledProgramID) {
        $this->enrolledProgramID = $enrolledProgramID;
    }

    public function getEnrolledProgramID() {
        return $this->enrolledProgramID;
    }

    public function setEnrolledProgram($enrolledProgram) {
        $this->enrolledProgram = $enrolledProgram;
    }

    public function getEnrolledProgram() {
        return $this->enrolledProgram;
    }

    public function getEnrolledProgramsByUserID(Adapter $eLearningDB, $userID) {
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

        $query = "select * from programs where id in (select DISTINCT program_id from enrolled_programs where user_id=:user_id) or type = 'free'";
        $result = $eLearningDB->query($query)->execute(array("user_id" => $userID));
        $enrolledPrograms = array();
        foreach ($result as $resultRow) {
            array_push($enrolledPrograms, array(
                "id" => $resultRow['id'],
                "program_name" => $resultRow['program_name'],
                "category" => $resultRow['category'],
                "chapters" => $resultRow['chapters'],
                "provider" => $resultRow['provider'],
                "duration" => $resultRow['duration'],
                "cost" => $resultRow['cost'],
            ));
        }
        return $enrolledPrograms;
    }

    public function getProgramList(Adapter $eLearningDB, $userID) {
        $query1 = "select * from enrolled_programs where user_id = :user_id";
        $result1 = $eLearningDB->query($query1)->execute(array("user_id" => $userID));
        $registeredProgramIDList = array();
        foreach($result1 as $result1Row){
            array_push($registeredProgramIDList, $result1Row["program_id"]);
        }
        $query = "select * from programs where is_published = 1";
        $programList = array();
        $result = $eLearningDB->query($query)->execute();
        foreach ($result as $programRow) {
            $isRegistered = false;
            if(in_array($programRow["id"], $registeredProgramIDList) || $programRow["type"] == "free"){
                $isRegistered = true;
            }           
            array_push($programList, array(
                "id" => $programRow["id"],
                "program_name" => $programRow["program_name"],
                "category" => $programRow["category"],
                "content" => $programRow["content"],
                "duration" => $programRow["duration"],
                "cost" => $programRow["cost"],
                "is_registered" => $isRegistered
            ));
        }        
        return $programList;
    }

    public function registerProgram(Adapter $eLearningDB, $userID) {
        $programID = $this->getProgramID();
        $query = "insert into enrolled_programs (user_id, program_id) values (:user_id, :program_id)";
        $result = $eLearningDB->query($query)->execute(array("user_id" => $userID, "program_id" => $programID));
        $count = $result->getAffectedRows();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllPrograms(Adapter $eLearningDB) {
        $query = "select * from programs";
        $result = $eLearningDB->query($query)->execute();
        $allProgramsData = array();
        foreach ($result as $resultRow) {
            array_push($allProgramsData, $resultRow);
        }
        return $allProgramsData;
    }

    public function createProgram(Adapter $eLearningDB, $program_data) {
        $program_name = isset($program_data->programName) ? $program_data->programName : "";
//        $chapters = isset($program_data->category) ? $program_data->category : "";
//        $content = isset($program_data->chapters) ? $program_data->chapters : "";
//        $duration = isset($program_data->content) ? $program_data->content : "";
        $duration = isset($program_data->duration) ? $program_data->duration : "";
        $cost = isset($program_data->cost) ? $program_data->cost : "";
//        $type = isset($program_data->type) ? $program_data->type : "";
        $provider = isset($program_data->provider) ? $program_data->provider : "";
        $insert_query = "insert into programs (program_name,duration,cost,provider) "
                . "values (:program_name,:duration,:cost,:provider)";
        $result = $eLearningDB->query($insert_query)->execute(array(
            "program_name" => $program_name,
//            "category" => $category,
//            "chapters" => $chapters,
//            "content" => $content,
            "duration" => $duration,
            "cost" => $cost,
//            "type" => $type,
            "provider" => $provider
        ));
    }

    public function updateProgram(Adapter $eLearningDB, $program_data) {
        $program_id = isset($program_data->program_id) ? $program_data->program_id : "";
        $program_name = isset($program_data->program_name) ? $program_data->program_name : "";
        $chapters = isset($program_data->category) ? $program_data->category : "";
        $content = isset($program_data->chapters) ? $program_data->chapters : "";
        $duration = isset($program_data->content) ? $program_data->content : "";
        $category = isset($program_data->duration) ? $program_data->duration : "";
        $cost = isset($program_data->cost) ? $program_data->cost : "";
        $type = isset($program_data->type) ? $program_data->type : "";

        $update_query = "update programs set program_name=:program_name,category=:category,chapters=:chapters,content=:content,duration=:duration,cost=:cost,"
                . "type=:type where id=:program_id";
        $result = $eLearningDB->query($update_query)->execute(array(
            "program_id" => $program_id,
            "program_name" => $program_name,
            "category" => $category,
            "chapters" => $chapters,
            "content" => $content,
            "duration" => $duration,
            "cost" => $cost,
            "type" => $type
        ));
    }
    
    public function addProgramChapter(Adapter $eLearningDB, $program_data){
        $program_id = $program_data->id;
        $query = "select * from programs where id = :program_id";
        $result = $eLearningDB->query($query)->execute(array("program_id" => $program_id))->current();
        if(empty($result["chapters"])){
           $chapters = array(); 
        }else{            
            $chapters = json_decode($result["chapters"], true);
        }
        $chapter = array(
            "title" => $program_data->tital,
            "type" => $program_data->type,
            "chapterUrl" => $program_data->chapterUrl
        );
        array_push($chapters, $chapter);
        
        $update_query = "update programs set chapters=:chapter where id = :program_id";
//        var_dump(array("program_id" => $program_id, "chapter" => json_encode($chapter)));
        $update_result = $eLearningDB->query($update_query)->execute(array("program_id" => $program_id, "chapter" => json_encode($chapters)));
    }
    
    public function deleteProgram(Adapter $eLearningDB){
        $programID = $this->getProgramID();
        $delete_query = "delete from programs where id=:program_id";
        $eLearningDB->query($delete_query)->execute(array("program_id" => $programID));
    }
    
    public function getProgramDetailsByProgramID(Adapter $eLearningDB){
        $programID = $this->getProgramID();
        $query = "select * from programs where id=:program_id";
        $result = $eLearningDB->query($query)->execute(array("program_id" => $programID))->current();
        $chapters = $result["chapters"];
        return $chapters;
    }
    
    public static function updateProgramPublishStatus(Adapter $eLearningDB, $programID){
        $query = "update programs set is_published = case when is_published = 1 then 0 else 1 end where id=:program_id";
        $eLearningDB->query($query)->execute(array("program_id" => $programID));
        $result = $eLearningDB->query("select * from programs where id = :program_id")->execute(array("program_id" => $programID))->current();
        $is_published = $result["is_published"];
        if($is_published == 1){
            $message = "Program has been published.";
        }else{
            $message = "Program has been unpublished.";
        }
        $response = array("message" => $message);
        return $response;
    }

}
