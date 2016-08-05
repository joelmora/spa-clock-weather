app.factory('weatherService', ['$http', function($http) {
    return {
        getCurrentWeather: function() {
            return $http.get('http://localhost/spa-clock-weather/php/weatherService.php')
                .success(function(result) {
                    return result;
                })
                .error(function(err) {
                    return err;
                });
        }
    };
}]);