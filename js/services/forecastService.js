app.factory('forecastService', ['$http', function($http) {
    return {
        getCurrentForecast: function() {
            return $http.get('json/forecast.json')
                .success(function(result) {
                    return result;
                })
                .error(function(err) {
                    return err;
                });
        }
    };
}]);