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
                .when('/instructor/manageCourses/:id', {
                    templateUrl: 'templates/manageCourse.html',
                    controller: 'manageCoursesController'
                })
                .when('/instructor/course/addBasicInfo', {
                    templateUrl: 'templates/addCourseBasicInfo.html',
                    controller: 'manageCourseInfoController'
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

//        $scope.addProgramFn = function (){
//            $scope.addProgram=true;
//            $scope.createProgram={};
//        };
//        $scope.addProgramFn = function () {
//            var url = "/instructor/manageCourses"
//            $location.path(url);
//        };
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
eLearningApp.controller('instructorDashboardController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
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
    }]);
eLearningApp.controller('manageCoursesController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
//        $http.get("getAllPrograms")
//                .success(function (response) {
//                    if (response.status === false && response.statusCode === "notAuthorised") {
//                        alert("notAuthorised");
//                        location.href = response.url;
//                    }
//                    $scope.allProgram = response;
//                });
        
        $scope.addBasicInfoFn = function () {
            alert("add program function")
            var url = "/instructor/course/addBasicInfo"
            $location.path(url);
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
eLearningApp.controller('manageCourseInfoController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
        
        $scope.addCourseBasicInfoFn = function (course_name, course_description, course_overview) {
//            alert("add program function")
            var url = "/addCourseBasicInfo"
            $location.path(url);
            $http.post("addCourseBasicInfo", {course_name: course_name, course_description: course_description, course_overview: course_overview})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert("Course Basic Information Is Added Successfully");
                        $scope.addChapter = false;
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

eLearningApp.controller('manageCoursePriceController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
        $scope.createPricingFn = function () {
//            alert("add program function")
            var url = "/instructor/course/createPricing"
            $location.path(url);
        };
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
