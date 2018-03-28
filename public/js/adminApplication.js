var eLearningApp = angular.module('eLearningApp', ["ngRoute"]);
eLearningApp.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
                .when('/adminPortal', {
                    templateUrl: 'templates/adminPortal.html',
                    controller: 'adminController'
                })
//                .when('/getAdminUserInfo', {
//                    templateUrl: 'templates/adminPortal.html',
//                    controller: 'adminController'
//                })
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
        
    }]);
