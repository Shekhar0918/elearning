var eLearningApp = angular.module('eLearningApp', ["ngRoute"]);
eLearningApp.directive('createprogram', function () {
    var directive = {};

    directive.restrict = 'E';

    directive.templateUrl = "templates/createProgram.html";

    directive.scope = {
        createprogram: "=createprogram"
    };

    return directive;
});
eLearningApp.service('courseDetailsService', function () {
    var courseID;
    var courseDetails;
    var setCourseID = function (id) {
        courseID = id;
    };
    var getCourseID = function () {
        return courseID;
    };
    var setCourseDetails = function (course) {
        courseDetails = course;
    };
    var getCourseDetails = function getCourseDetails() {
        return courseDetails;
    };
    return {
        setCourseID: setCourseID,
        getCourseID: getCourseID,
        setCourseDetails: setCourseDetails,
        getCourseDetails: getCourseDetails

    };
});
eLearningApp.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
                .when('/adminPortal', {
                    templateUrl: 'templates/adminPortal.html',
                    controller: 'mainController'
                })
                .when('/instructor/dashboard', {
                    templateUrl: 'templates/instructorDashboard.html',
                    controller: 'instructorDashboardController'
                })
                .when('/instructor/manageCourses/:course_id', {
                    templateUrl: 'templates/manageCourse.html',
                    controller: 'manageCoursesController'
                })
                .when('/instructor/manageCourses/:course_id/addBasicInfo', {
                    templateUrl: 'templates/addCourseBasicInfo.html',
                    controller: 'manageCourseInfoController'
                })
                .when('/instructor/manageCourses/:course_id/pricing', {
                    templateUrl: 'templates/coursePricing.html',
                    controller: 'manageCoursePriceController'
                })
                .when('/instructor/manageCourses/:course_id/instructors', {
                    templateUrl: 'templates/courseInstructors.html',
                    controller: 'manageCourseInstructorsController'
                })
                .when('/instructor/manageCourses/:course_id/chapters', {
                    templateUrl: 'templates/courseChapters.html',
                    controller: 'manageCourseChaptersController'
                })
        $locationProvider.html5Mode(true);
    }]);

eLearningApp.controller('mainController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
        $http.get("getAdminUserInfo")
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    }
//                    alert(response.name);
                    $rootScope.name = response.name;
                    $rootScope.email = response.email;
                    $rootScope.access_type = response.access_type;
                });
    }]);

eLearningApp.controller('adminController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
        $scope.cancelAddProgram = function () {
            $scope.addProgram = false;
        };
//        $http.get("getAllPrograms")
//                .success(function (response) {
//                    if (response.status === false && response.statusCode === "notAuthorised") {
//                        alert("notAuthorised");
//                        location.href = response.url;
//                    }
//                    $scope.allProgram = response;
//                });
        $scope.addChapterFn = function (id) {
            $scope.addChapter = true;
            $scope.selectedProgramId = id;
        };
        $scope.cancelAddChapter = function () {
            $scope.addChapter = false;
        };
        $scope.AddChapterFn = function (tital, type, chapterUrl, id) {
            var data = {};
            data.tital = tital;
            data.type = type;
            data.chapterUrl = chapterUrl;
            data.id = id;
            $http.post("addProgramChapter", data)
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert("Chapter Added Successfully");
                        $scope.addChapter = false;
                        $rootScope.notify('<div class="alert alert-success">Chaptor Added Successfully</div>');
                    });
        };
        $scope.deleteProgramFn = function (id) {
            $http.post("deleteProgram", {program_id: id})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert("Program Deleted Successfully");
                        $route.reload();
                        $rootScope.notify('<div class="alert alert-success">Program Deleted Successfully</div>');
                    });
        };
        $scope.publishProgramFn = function (id) {
            $http.post("publishProgram", {program_id: id})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert(response.message)
                        $route.reload();
                        $rootScope.notify('<div class="alert alert-success">' + response.message + '</div>');
                    });
        };
    }]);
eLearningApp.controller('instructorDashboardController', ['$scope', '$location', '$http', '$rootScope', '$route', 'courseDetailsService', function ($scope, $location, $http, $rootScope, $route, courseDetailsService) {
        $scope.addProgramFn = function () {
            $http.post("createNewCourse")
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        var url = "/instructor/manageCourses/" + response.id;
                        $location.path(url);
                        alert(response.name + " Is Created.");
                        $scope.course_id = response.id;
                        $scope.course_name = response.name;
                        courseDetailsService.setCourseID(response.id);
                        $rootScope.notify('<div class="alert alert-success">Course Basic Information Is Added Successfully</div>');
                    });
        };
        $http.get("getAllPrograms")
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    }
                    $scope.allProgram = response;
                });
        $http.get("getAllCourses")
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    }
                    $scope.allCourse = response;
                });
        
        $scope.deleteCourseFn = function (id) {
            $http.post("deleteCourse", {courseID: id})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert("Course Deleted Successfully");
                        $route.reload();
                        $rootScope.notify('<div class="alert alert-success">Course Deleted Successfully</div>');
                    });
        };        
        $scope.publishCourseFn = function (id) {
            $http.post("publishCourse", {courseID: id})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert(response.message)
                        $route.reload();
                        $rootScope.notify('<div class="alert alert-success">' + response.message + '</div>');
                    });
        };
    }]);
eLearningApp.controller('manageCoursesController', ['$scope', '$location', '$http', '$rootScope', '$route', 'courseDetailsService', function ($scope, $location, $http, $rootScope, $route, courseDetailsService) {
        $scope.courseID = courseDetailsService.getCourseID();
        $http.get("getCourseDetailsByID?courseID=" + $scope.courseID)
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    }
                    $scope.courseDetails = response;
                    courseDetailsService.setCourseDetails(response);
                });
        $scope.addBasicInfoFn = function () {
            var url = "/instructor/manageCourses/" + $scope.courseID + "/addBasicInfo"
            $location.path(url);
        }

        $scope.createPricingFn = function () {
            var url = "/instructor/manageCourses/" + $scope.courseID + "/pricing"
            $location.path(url);
        };
        $scope.manageChaptersFn = function () {
            var url = "/instructor/manageCourses/" + $scope.courseID + "/chapters"
            $location.path(url);
        };
        $scope.manageInstructorsFn = function () {
            var url = "/instructor/manageCourses/" + $scope.courseID + "/instructors"
            $location.path(url);
        };
    }]);
eLearningApp.controller('manageCourseInfoController', ['$scope', '$location', '$http', '$rootScope', '$route', 'courseDetailsService', function ($scope, $location, $http, $rootScope, $route, courseDetailsService) {
        $scope.courseID = courseDetailsService.getCourseID();
        $scope.courseDetails = courseDetailsService.getCourseDetails();
        $http.get("getCourseDetailsByID?courseID=" + $scope.courseID)
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    }
                    $scope.courseDetails = response;
                    courseDetailsService.setCourseDetails(response);
                });
        $scope.addCourseBasicInfoFn = function (courseDetails) {
//            alert("add program function")
//            var url = "/addCourseBasicInfo"
//            $location.path(url);
            $http.post("updateCourseBasicInfo", {courseID: $scope.courseID, courseName: courseDetails.name, courseDescription: courseDetails.course_description, courseOverview: courseDetails.course_overview, duration: courseDetails.course_overview, provider: courseDetails.provider})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);

                        var url = "/instructor/manageCourses/" + $scope.courseID;
                        $location.path(url);
                        alert("Course Basic Information Is Updated Successfully");
//                        $scope.addChapter = false;
                        $rootScope.notify('<div class="alert alert-success">Course Basic Information Is Added Successfully</div>');
                    });
        }
        $scope.createPricingFn = function () {
//            alert("add program function")
            var url = "/instructor/course/createPricing"
            $location.path(url);
        };
        $scope.manageChaptersFn = function () {
//            alert("add program function")
            var url = "/instructor/course/manageChapters"
            $location.path(url);
        };
        $scope.manageInstructorsFn = function () {
//            alert("add program function")
            var url = "/instructor/course/manageInstructors"
            $location.path(url);
        };
    }]);
eLearningApp.controller('manageCoursePriceController', ['$scope', '$location', '$http', '$rootScope', '$route', 'courseDetailsService', function ($scope, $location, $http, $rootScope, $route, courseDetailsService) {
        $scope.courseID = courseDetailsService.getCourseID();
        $http.get("getCourseDetailsByID?courseID=" + $scope.courseID)
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    }
                    $scope.courseDetails = response;
                    courseDetailsService.setCourseDetails(response);
                });
        $scope.coursePricingFn = function () {      
            $http.post("updateCoursePrice", {courseID: $scope.courseID, price: $scope.courseDetails.price})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);

                        var url = "/instructor/manageCourses/" + $scope.courseID;
                        $location.path(url);
                        alert("Course Price has Been Updated Successfully");
//                        $scope.addChapter = false;
                        $rootScope.notify('<div class="alert alert-success">Course Price has Been Updated Successfully</div>');
                    });
        };
    }]);
eLearningApp.controller('manageCourseInstructorsController', ['$scope', '$location', '$http', '$rootScope', '$route', 'courseDetailsService', function ($scope, $location, $http, $rootScope, $route, courseDetailsService) {
        $scope.courseID = courseDetailsService.getCourseID();
        $http.get("getCourseDetailsByID?courseID=" + $scope.courseID)
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    }
                    $scope.courseDetails = response;
                    courseDetailsService.setCourseDetails(response);
                });
        $scope.addCourseInstructorFn = function () {      
            $http.post("addCourseInstructor", {courseID: $scope.courseID, instructorName: $scope.courseDetails.instructorName, instructorEmail: $scope.courseDetails.instructorEmail})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);

                        var url = "/instructor/manageCourses/" + $scope.courseID + "/instructors";
                        $location.path(url);
                        $route.reload();
                        alert("Course Instructor has Been Added Successfully");console.log($scope.courseDetails)
//                        $scope.addChapter = false;
                        $rootScope.notify('<div class="alert alert-success">Course Instructor has Been Added Successfully</div>');
                    });
        };
    }]);
eLearningApp.controller('manageCourseChaptersController', ['$scope', '$location', '$http', '$rootScope', '$route', 'courseDetailsService', function ($scope, $location, $http, $rootScope, $route, courseDetailsService) {
        $scope.courseID = courseDetailsService.getCourseID();
        $http.get("getCourseDetailsByID?courseID=" + $scope.courseID)
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    }
                    $scope.courseDetails = response;
                    courseDetailsService.setCourseDetails(response);
                });
        $scope.types = ["Video", "PDF"];
        $scope.createCourseChapterFn = function () {      
            $http.post("createCourseChapter", {courseID: $scope.courseID, chapter: $scope.chapter})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);

                        var url = "/instructor/manageCourses/" + $scope.courseID + "/chapters";
                        $location.path(url);
                        $route.reload();
                        alert("Chapter has Been Added Successfully");
//                        $scope.addChapter = false;
                        $rootScope.notify('<div class="alert alert-success">Chapter has Been Added Successfully</div>');
                    });
        };
        $scope.deleteChapterFn = function(chapter){
            $http.post("deleteChapter", {courseID: $scope.courseID, chapter: chapter})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);

                        var url = "/instructor/manageCourses/" + $scope.courseID + "/chapters";
                        $location.path(url);
                        $route.reload();
                        alert("Chapter has Been Deleted Successfully");
//                        $scope.addChapter = false;
                        $rootScope.notify('<div class="alert alert-success">Chapter has Been Deleted Successfully</div>');
                    });
        }
    }]);
eLearningApp.createProgramController = ['$scope', '$element', '$location', '$http', '$route', '$rootScope', function ($scope, $element, $location, $http, $route, $rootScope) {
        $scope.createProgramFn = function (data) {
            $http.post("createProgram", data)
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert("Program Created Successfully");
                        $route.reload();
                        $rootScope.notify('<div class="alert alert-success">Program Created Successfully</div>');
                    });
        };
    }];
