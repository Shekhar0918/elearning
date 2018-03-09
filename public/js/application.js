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
//                        alert("notAuthorised");
                        location.href = response.url;
                    } else if (response.status === "failed") {
//                         alert("failed");
                        alert(location.href = 'signup')
                    } else {
//                        alert(response.status);
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
//                                    alert("hii");
//                                    alert(response[0].program_name);
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