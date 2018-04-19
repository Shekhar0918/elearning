<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class Course {

    private $courseID;
    private $courseName;
    private $courseDescription;
    private $courseOverview;
    private $instructors;
    private $coursePrice;
    private $instructorName;
    private $instructorEmail;
    private $type;
    private $chapterName;
    private $chapterURL;

    function __construct() {
        
    }

    public function setCourseID($courseID) {
        $this->courseID = $courseID;
    }

    public function getCourseID() {
        return $this->courseID;
    }

    public function setCourseName($courseName) {
        $this->courseName = $courseName;
    }

    public function getCourseName() {
        return $this->courseName;
    }

    public function setCourseDescription($courseDescription) {
        $this->courseDescription = $courseDescription;
    }

    public function getCourseDescription() {
        return $this->courseDescription;
    }

    public function setCourseOverview($courseOverview) {
        $this->courseOverview = $courseOverview;
    }

    public function getCourseOverview() {
        return $this->courseOverview;
    }

    public function setInstructors($instructors) {
        $this->instructors = $instructors;
    }

    public function getInstructors() {
        return $this->instructors;
    }

    public function setCoursePrice($coursePrice) {
        $this->coursePrice = $coursePrice;
    }

    public function getCoursePrice() {
        return $this->coursePrice;
    }

    public function setInstructorName($instructorName) {
        $this->instructorName = $instructorName;
    }

    public function getInstructorName() {
        return $this->instructorName;
    }

    public function setInstructorEmail($instructorEmail) {
        $this->instructorEmail = $instructorEmail;
    }

    public function getInstructorEmail() {
        return $this->instructorEmail;
    }
    
    public function setType($type){
        $this->type = $type;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function setChapterName($chapterName){
        $this->chapterName = $chapterName;
    }
    
    public function getChapterName(){
        return $this->chapterName;
    }
    
    public function setChapterURL($chapterURL){
        $this->chapterURL = $chapterURL;
    }
    
    public function getChapterURL(){
        return $this->chapterURL;
    }

    public static function getCourseByID(Adapter $eLearningDB, $courseID) {
        $query = "select * from courses where id=:courseID";
        $courseDetailsResult = $eLearningDB->query($query)->execute(array("courseID" => $courseID))->current();
        $courseDetails = new Course();
        $courseDetails->courseName = $courseDetailsResult['name'];
        $courseDetails->courseDescription = $courseDetailsResult['course_description'];
        $courseDetails->courseOverview = $courseDetailsResult['course_overview'];
        $courseDetails->instructors = $courseDetailsResult['instructors'];
        return $courseDetails;
    }

    public function createNewCourse(Adapter $eLearningDB) {
        $query = "insert into courses (name) values(:name)";
        $eLearningDB->query($query)->execute(array("name" => "Untitled Course"));
        $courseID = $eLearningDB->getDriver()->getLastGeneratedValue();
        $courseName = "Untitled Course $courseID";
        $eLearningDB->query("update courses set name = :name where id=:course_id")->execute(array("name" => $courseName, "course_id" => $courseID));
        $response = array("id" => $courseID, "name" => $courseName);
        return $response;
    }

    public function updateCourseBasicInfo(Adapter $eLearningDB) {
        $courseID = $this->getCourseID();
        $courseName = $this->getCourseName();
        $courseDescription = $this->getCourseDescription();
        $courseOverview = $this->getCourseOverview();
        $query = "update courses set name = :name, course_description = :course_description, course_overview = :course_overview where id=:courseID";
        $eLearningDB->query($query)->execute(array("courseID" => $courseID, "name" => $courseName, "course_description" => $courseDescription, "course_overview" => $courseOverview));
    }

    public function getCouseDetailsByID(Adapter $eLearningDB) {
        $courseID = $this->getCourseID();
        $query = "select * from courses where id='$courseID'";
        $courseDetails = $eLearningDB->query($query)->execute(array("courseID" => $courseID))->current();
        $courseDetails["instructors"] = json_decode($courseDetails["instructors"]);
        $courseDetails["chapters"] = json_decode($courseDetails["chapters"]);
        return $courseDetails;
    }

    public function updateCoursePrice(Adapter $eLearningDB) {
        $courseID = $this->getCourseID();
        $coursePrice = $this->getCoursePrice();
        $query = "update courses set price = :price where id = :courseID";
        $eLearningDB->query($query)->execute(array("price" => $coursePrice, "courseID" => $courseID));
    }

    public function addCourseInstructor(Adapter $eLearningDB) {
        $courseID = $this->getCourseID();
        $instructorName = $this->getInstructorName();
        $instructorEmail = $this->getInstructorEmail();
        $selectQuery = "select * from courses where id = :courseID";
        $selectResult = $eLearningDB->query($selectQuery)->execute(array("courseID" => $courseID))->current();
        $instructors = !empty($selectResult['instructors']) ? json_decode($selectResult['instructors']) : array();
        if (count($instructors) > 0) {
            $instructor_id = (int) $instructors[count($instructors) - 1]->id + 1;
        } else {
            $instructor_id = 1;
        }
        $instructor_created_at = new \DateTime('now');
        array_push($instructors, array(
            "id" => $instructor_id,
            "instructor_name" => $instructorName,
            "instructor_email" => $instructorEmail,
            "instructor_created_at" => $instructor_created_at->format("d M Y")
        ));
//        var_dump(array("instructors" => json_encode($instructors), "courseID" => $courseID));
        
        $updateQuery = "update courses set instructors = :instructors where id = :courseID";
        $eLearningDB->query($updateQuery)->execute(array("instructors" => json_encode($instructors), "courseID" => $courseID));
    }
    
    public function createChapter(Adapter $eLearningDB){
        $courseID = $this->courseID;
        $chapterName = $this->getChapterName();
        $chapterURL = $this->getChapterURL();
        $type = $this->type;
        $selectQuery = "select * from courses where id = :courseID";
        $selectResult = $eLearningDB->query($selectQuery)->execute(array("courseID" => $courseID))->current();
        $chapters = !empty($selectResult['chapters']) ? json_decode($selectResult['chapters']) : array();
        if (count($chapters) > 0) {
            $chapter_id = (int) $chapters[count($chapters) - 1]->id + 1;
        } else {
            $chapter_id = 1;
        }
        array_push($chapters, array(
            "id" => $chapter_id,
            "chapterName" => $chapterName,
            "chapterURL" => $chapterURL,
            "type" => $type
        ));
        $updateQuery = "update courses set chapters = :chapters where id = :courseID";
        $eLearningDB->query($updateQuery)->execute(array("chapters" => json_encode($chapters), "courseID" => $courseID));
    }

}
