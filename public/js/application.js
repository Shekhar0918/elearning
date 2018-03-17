var eLearningApp = angular.module('eLearningApp', ["ngRoute"]);
eLearningApp.directive('listofprogram', function () {
    var directive = {};

    directive.restrict = 'E';

    directive.templateUrl = "templates/listOfProgram.html";

    directive.scope = {
        listofprogram: "=listofprogram"
    };

    return directive;
});
eLearningApp.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
                .when("/", {
                    templateUrl: "templates/home.html",
                    controller: 'homeController'
                })
                .when("/_=_", {
                    templateUrl: "templates/home.html",
                    controller: 'homeController'
                })
                .when("/enrolledProgram", {
                    templateUrl: "templates/enrolledProgram.html",
                    controller: 'enrolledProgramController'
                })
//            .when('/signup', {
//                template: 'templates/signup.html',
//                controller: 'mainController'
//            })
//            .when('/facebookSignup', {
//                template: 'templates/home.html',
//                controller: 'mainController'
//            })
        $locationProvider.html5Mode(true);
    }]);
eLearningApp.controller('homeController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {

    }]);
eLearningApp.controller('mainController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
        $http.get('getUserInfo')
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        alert("notAuthorised");
                        location.href = response.url;
                    } else if (response.status === "failed") {
                        alert("failed");
                        location.href = response.url;//'signup'
                    } else {
//                        alert(response.status);
                        $scope.name = response.userInfo.name;
                        $scope.designation = response.userInfo.designation;
                        $scope.organization = response.userInfo.organization;
                        $scope.city = response.userInfo.city;
                        $scope.phone = response.userInfo.phone;
                        $scope.country = response.userInfo.country;
                        $scope.business_email = response.userInfo.business_email;
                    }
                });
//        }
    }]);

eLearningApp.controller('enrolledProgramController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
        $http.get('getEnrolledPrograms')
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        location.href = response.url;
                    }
                    $scope.enrolled_program_list = response;
                });
        $scope.newProgramfn = function () {
            $scope.showEnrollProgram = true;
        };
        $scope.cancelEnrollProgram = function () {
            $scope.showEnrollProgram = false;
        };
    }]);
eLearningApp.listOfProgramController = ['$scope', '$element', '$location', '$http', '$route', '$rootScope',
    function ($scope, $element, $location, $http, $route, $rootScope) {

        $http.get('getProgramList')
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        location.href = response.url;
                    }
                    $scope.program_list = response;
                });

        $scope.registerFn = function (program) {
            console.log(program);
            $http.post('registerProgram', {program: program})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised") {
                            location.href = response.url;
                        }
                        $scope.response = response;
                    });
        };

    }];