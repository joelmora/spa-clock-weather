app.factory('forecastService', ['$http', function($http) {
    return {
        getCurrentForecast: function() {
            return $http.get('http://localhost/spa-clock-weather/php/forecastService.php')
                .success(function(result) {
                    return result;
                })
                .error(function(err) {
                    return err;
                });
        }
    };
}]);