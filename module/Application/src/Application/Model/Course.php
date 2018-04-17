<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class Course {
    private $courseID;
    private $courseName;
    private $courseDescription;
    private $courseOverview;
    
    function __construct() {
        
    }
    
    public function setCourseID($courseID){
        $this->courseID = $courseID;
    }
    public function getCourseID(){
        return $this->courseID;
    }
    public function setCourseName($courseName){
        $this->courseName = $courseName;
    }
    public function getCourseName(){
        return $this->courseName;
    }
    public function setCourseDescription($courseDescription){
        $this->courseDescription = $courseDescription;
    }
    public function getCourseDescription(){
        return $this->courseDescription;
    }
    public function setCourseOverview($courseOverview){
        $this->courseOverview = $courseOverview;
    }
    public function getCourseOverview(){
        return $this->courseOverview;
    }
    
    public function createNewCourse(Adapter $eLearningDB){
        $query = "insert into courses (name) values(:name)";
        $eLearningDB->query($query)->execute(array("name" => "Untitled Course"));
        $courseID = $eLearningDB->getDriver()->getLastGeneratedValue();
        $courseName = "Untitled Course $courseID";
        $eLearningDB->query("update courses set name = :name where id=:course_id")->execute(array("name" => $courseName, "course_id" => $courseID));
        $response = array("id" => $courseID, "name" => $courseName);
        return $response;
    }
    
    public function addCourseBasicInfo(Adapter $eLearningDB){
        $course_name = $this->getCourseName();
        $course_description = $this->getCourseDescription();
        $course_overview = $this->getCourseOverview();
        $query = "insert into courses (name, course_description, course_overview) values(:name, :course_description, :course_overview)";
        $eLearningDB->query($query)->execute(array("name" => $course_name, "course_description" => $course_description, "course_overview" => $course_overview));
    }
    
}
