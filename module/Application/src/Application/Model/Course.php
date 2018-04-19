<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class Course {
    private $courseID;
    private $courseName;
    private $courseDescription;
    private $courseOverview;
    private $instructors;
    
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
    public function setInstructors($instructors){
        $this->instructors = $instructors;
    }
    public function getInstructors(){
        return $this->instructors;
    }
    public static function getCourseByID(Adapter $eLearningDB, $courseID){
        $query = "select * from courses where id=:courseID";
        $courseDetailsResult = $eLearningDB->query($query)->execute(array("courseID" => $courseID))->current();
        $courseDetails = new Course();
        $courseDetails->courseName = $courseDetailsResult['name'];
        $courseDetails->courseDescription = $courseDetailsResult['course_description'];
        $courseDetails->courseOverview = $courseDetailsResult['course_overview'];
        $courseDetails->instructors = $courseDetailsResult['instructors'];
        return $courseDetails;
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
    
    public function updateCourseBasicInfo(Adapter $eLearningDB){
        $courseID = $this->getCourseID();
        $courseName = $this->getCourseName();
        $courseDescription = $this->getCourseDescription();
        $courseOverview = $this->getCourseOverview();
        $query = "update courses set name = :name, course_description = :course_description, course_overview = :course_overview where id=:courseID";
        $eLearningDB->query($query)->execute(array("courseID" => $courseID, "name" => $courseName, "course_description" => $courseDescription, "course_overview" => $courseOverview));
    }
    
    public function getCouseDetailsByID(Adapter $eLearningDB){
        $courseID = $this->getCourseID();
        $query = "select * from courses where id='$courseID'";
        $courseDetails = $eLearningDB->query($query)->execute(array("courseID" => $courseID))->current();
        return $courseDetails;
    }
}
