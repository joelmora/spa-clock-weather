app.factory('weatherService', ['$http', function($http) {
    return {
        getCurrentWeather: function() {
            return $http.get('json/weather.json')
                .success(function(result) {
                    return result;
                })
                .error(function(err) {
                    return err;
                });
        }
    };
}]);