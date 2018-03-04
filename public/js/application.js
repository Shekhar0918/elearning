var eLearningApp = angular.module('eLearningApp', ["ngRoute"]);

eLearningApp.config(function ($routeProvider) {
    $routeProvider
            .when("/", {
                templateUrl: "templates/home.html",
                controller: 'homeController'
            })
            .when('/signup', {
                template: 'templates/signup.html',
                controller: 'mainController'
            })
            .when('/googleSignup', {
                template: 'templates/signup.html',
                controller: 'mainController'
            })
//            $locationProvider.html5Mode(true);
});

eLearningApp.controller('mainController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
//        alert("hii");
//        $scope.getUserInfoFn = function () {
        $http.get('getUserInfo')
                .success(function (response) {
                    if (response.status === false && response.statusCode === "notAuthorised") {
//                        alert("notAuthorised");
                        location.href = response.url;
                    } else if (response.status === "failed") {
//                         alert("failed");
                        alert(location.href = 'signup')
                    } else {
                        alert(response.status);
                        $scope.user_id = response.userInfo.userID;
                        $scope.first_name = response.userInfo.firstName;
                        $scope.last_name = response.userInfo.lastName;
                        $scope.access_type = response.userInfo.accessType;
                        $scope.source = response.userInfo.source;

                        $http.get('getEnrolledPrograms')
                                .success(function (response) {
                                    if (response.status === false && response.statusCode === "notAuthorised") {
                                        location.href = response.url;
                                    } 
                                    $scope.enrolled_program_list = response;
                                });



                    }
                });
//        }
    }]);

eLearningApp.controller('homeController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {

    }]);