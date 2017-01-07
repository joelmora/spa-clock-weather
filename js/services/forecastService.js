angular.module('dashboardApp').factory('forecastService',
    ['$http', 'FORECAST_URL', function($http, FORECAST_URL) {

        /**
         * Call the backend to retrieve the forecast data
         * @returns {*}
         */
        function getCurrentForecast()
        {
            return $http.get(FORECAST_URL)
                .success(function(result) {
                    return result;
                })
                .error(function(err) {
                    return err;
                });
        }
        
        return {
            'getCurrentForecast': getCurrentForecast
        };
    }]);