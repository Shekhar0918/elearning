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
        
        $scope.addProgramFn = function (){
            $scope.addProgram=true;
            $scope.createProgram={};
        };
        $scope.cancelAddProgram = function (){
            $scope.addProgram=false;
        };
        $http.get("getAllPrograms")
           .success(function (response) {
               if (response.status === false && response.statusCode === "notAuthorised") {
                   alert("notAuthorised");
                   location.href = response.url;
               }
               $scope.allProgram = response;
           });
        $scope.addChapterFn = function(id){
            $scope.addChapter=true;
            $scope.selectedProgramId=id;
        };
        $scope.cancelAddChapter = function (){
            $scope.addChapter=false;
        };
        $scope.AddChapterFn = function(tital,type,chapterUrl,id){
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
                        $scope.addChapter=false;
                        $rootScope.notify('<div class="alert alert-success">Chaptor Added Successfully</div>');
                    });
        };
        $scope.deleteProgramFn = function(id){
            $http.post("deleteProgram", {program_id : id})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert("Program Deleted Successfully");
                        $route.reload();
                        $rootScope.notify('<div class="alert alert-success">Program Deleted Successfully</div>');
                    });
        };
        $scope.publishProgramFn = function(id){
            $http.post("publishProgram", {program_id : id})
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            $location.path(response.url);
                        alert(response.message)
                        $route.reload();
                        $rootScope.notify('<div class="alert alert-success">' + response.message + '</div>');
                    });
        };
    }]);

eLearningApp.createProgramController = ['$scope', '$element', '$location', '$http', '$route', '$rootScope', function ($scope, $element, $location, $http, $route, $rootScope) {
        $scope.createProgramFn = function(data){
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
