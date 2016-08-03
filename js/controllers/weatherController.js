app.controller('weatherController', ['$scope', 'weather', function($scope, weather) {

    weather.success(function(data) {
        $scope.weather = data;
    });

}]);