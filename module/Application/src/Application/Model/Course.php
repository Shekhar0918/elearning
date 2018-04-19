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
        return $courseDetails;
    }

    public function updateCoursePrice(Adapter $eLearningDB) {
        $courseID = $this->getCourseID();
        $coursePrice = $this->getCoursePrice();
        $query = "update courses set price = :price where id = :courseID";
        $eLearningDB->query($query)->execute(array("price" => $coursePrice, "courseID" => $courseID));
    }

    public function addCourseInstructor(Adapter $eLearingDB) {
        $courseID = $this->getCourseID();
        $instructorName = $this->getInstructorName();
        $instructorEmail = $this->getInstructorEmail();
        $selectQuery = "select * from courses where id = :courseID";
        $selectResult = $eLearingDB->query($selectQuery)->execute(array("courseID" => $courseID))->current();
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
        $eLearingDB->query($updateQuery)->execute(array("instructors" => json_encode($instructors), "courseID" => $courseID));
    }

}
