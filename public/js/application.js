var eLearningApp = angular.module('eLearningApp', ["ngRoute"]);

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

eLearningApp.controller('mainController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
//        alert("hii");
//        $scope.getUserInfoFn = function () {
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
//                        alert("user data");
                        $http.get('getEnrolledPrograms')
                                .success(function (response) {
                                    if (response.status === false && response.statusCode === "notAuthorised") {
//                                        alert(response.url);
                                        location.href = response.url;
                                    }
//                                    alert("user data 2");
                                    $scope.enrolled_program_list = response;
//                                    setTimeout(function () {
//                                        for (var i = 0; i < response.length; i++) {
//                                            for (var j = 0; j < response[i].chapters.length; j++) {
//                                                var vidioIframe = '<iframe width="280" height="315" src="' + response[i].chapters[j].content + '"></iframe>';
////                                                var vidioIframe = ' <video controls="true"><source src="' + response[i].courses[j].content + '" type="video/mp4" /></video>';
//                                                var videoSrc = $.parseHTML(vidioIframe);
//                                                $("#id_" + i + "_" + j).html(videoSrc);
//                                                
//                                            }
//                                        }
//                                    });
                                });
                                //html part link : <div ng-click="linkOnvideoLinkFn(src)">src</div>
//                                $scope.linkOnvideoLinkFn=function(src){
//                                    $("#videoBlock").attr("src",src);
//                                }



                    }
                });
//        }
    }]);

eLearningApp.controller('homeController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {

    }]);