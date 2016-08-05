app.controller('meteorologyController', ['$scope', 'weatherService', 'forecastService', function($scope, weatherService, forecastService) {

    weatherService.success(function(data) {
        $scope.weather = data;
    });

    forecastService.success(function(data) {
        $scope.forecast = data;
    });

}]);