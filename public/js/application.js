var eLearningApp = angular.module('eLearningApp', ["ngRoute"]);

eLearningApp.config(function($routeProvider){
    $routeProvider.when("/", {
        templateUrl : "templates/home.html", 
        controller: 'homeController'
    });
});

eLearningApp.controller('mainController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {
        
            $http.get('getUserInfo')
                    .success(function (response) {
                        if (response.status === false && response.statusCode === "notAuthorised")
                            location.href = response.url;
//                        alert(response);
                        $scope.user_id = response.userID;
                        $scope.first_name =response.firstName;
                        $scope.last_name = response.lastName;
                        $scope.access_type = response.accessType;
                        $scope.source = response.source;
                    });
}]);

eLearningApp.controller('homeController', ['$scope', '$location', '$http', '$rootScope', '$route', function ($scope, $location, $http, $rootScope, $route) {

}]);