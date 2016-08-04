app.factory('forecastService', ['$http', function($http) {
    return $http.get('http://localhost/spa-clock-weather/php/forecastService.php')
        .success(function(result) {
            return result;
        })
        .error(function(err) {
            return err;
        });
}]);