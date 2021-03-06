var eLearningApp = angular.module('eLearningApp', ["ngRoute"]);
eLearningApp.directive('listofprogram', function () {
    var directive = {};

    directive.restrict = 'E';

    directive.templateUrl = "templates/listOfProgram.html?random_number=" + Math.random();

    directive.scope = {
        listofprogram: "=listofprogram"
    };

    return directive;
});
eLearningApp.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
                .when("/", {
                    templateUrl: "templates/home.html",
                    controller: 'mainController'
                })
                .when("/_=_", {
                    templateUrl: "templates/home.html",
                    controller: 'mainController'
                })
                .when("/enrolledProgram", {
                    templateUrl: "templates/enrolledProgram.html",
                    controller: 'enrolledProgramController'
                })
                .when("/enrolledProgram/:program_id", {
                    templateUrl: "templates/showProgram.html",
                    controller: 'programDetailController'
                })
//                .when('/adminPortal', {
//                    template: 'templates/adminPortal.html',
//                    controller: 'adminController'
//                })
//                .when('/getAdminUserInfo', {
//                    template: 'templates/adminPortal.html',
//                    controller: 'adminController'
//                })
//            .when('/facebookSignup', {
//                template: 'templates/home.html',
//                controller: 'mainController'
//            })
        $locationProvider.html5Mode(true);
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
                        $scope.google_email_id = response.userInfo.google_email_id;
                        $scope.facebook_email_id = response.userInfo.facebook_email_id;
                    }
                });
        $scope.verifyAccountFn = function ($account_id) {
            console.log($account_id);
            $http.post('verifyAccount', {account_id: $account_id})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised") {
                            location.href = response.url;
                        }
                        $scope.response = response;
                    });
        };
    }]);

eLearningApp.controller('enrolledProgramController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
        $http.get('getEnrolledPrograms')
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        location.href = response.url;
                    }
                    $scope.enrolled_program_list = response;
                });
                $scope.viewProgramFn = function(program){
                    var url="/enrolledProgram/"+program.id
                    $location.path(url);
                };
        $scope.newProgramfn = function () {
            $scope.showEnrollProgram = true;
        };
        $scope.cancelEnrollProgram = function () {
            $scope.showEnrollProgram = false;
        };
    }]);

eLearningApp.controller('programDetailController', ['$scope', '$location', '$http', '$rootScope', '$route','$routeParams', function ($scope, $location, $http, $rootScope, $route,$routeParams) {
        $scope.programId = $routeParams.program_id;
        var url = "getProgramDetail/" + $scope.programId;
        $http.get(url)
            .success(function (response) {
                if (response.status === false && response.statusCode === "notAuthorised") {
                    location.href = response.url;
                }
                $scope.chapterList = response;
                $('#videoContaner').html(response[0].chapterUrl)
                $('#videoContaner').find("iframe").width(560);
                $('#videoContaner').find("iframe").height(315)
            });
            $scope.playVideoFn = function(program){
                $('#videoContaner').html(program.chapterUrl)
                $('#videoContaner').find("iframe").width(560);
                $('#videoContaner').find("iframe").height(315)
            };
    }]);

eLearningApp.listOfProgramController = ['$scope', '$element', '$location', '$http', '$route', '$rootScope', function ($scope, $element, $location, $http, $route, $rootScope) {
        $http.get('getProgramList')
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
                        location.href = response.url;
                    }
                    $scope.program_list = response;
                });
        
        $scope.registerFn = function (program) {
//            console.log(program);
            $http.post('registerProgram', {program: program})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised") {
                            location.href = response.url;
                        }
                        alert("New program is registered")
                        $scope.response = response;
                        $route.reload();
                    });
        };

    }];