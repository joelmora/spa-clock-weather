angular.module('dashboardApp').factory('weatherService',
    ['$http', 'WEATHER_URL', function($http, WEATHER_URL) {

        /**
         * Call the backend to retrieve the weather data
         * @returns {*}
         */
        function getCurrentWeather()
        {

            return $http.get(WEATHER_URL)
                .success(function(result) {
                    return result;
                })
                .error(function(err) {
                    return err;
                });
        }
        
        return {
            'getCurrentWeather': getCurrentWeather
        };
    }]);