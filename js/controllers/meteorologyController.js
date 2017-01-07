angular.module('dashboardApp').controller('meteorologyController',
    ['$scope', 'weatherService', 'forecastService', 'spinnerService', '$translate', '$interval', function($scope, weatherService, forecastService, spinner, $translate, $interval) {
        var weatherTimestamp, forecastTimestamp;
        var weatherChecker, forecastChecker;
        var updateWeatherEveryMinutes = 5;
        var updateForecastEveryHours = 3;

        /**
         * Return the current time
         * @returns {*}
         */
        $scope.getHour = function()
        {
            return moment().format('HH:mm');
        };

        /**
         * Get the temperature/windChill
         * @param type
         * @returns {*}
         */
        $scope.getTemperature = function(type)
        {
            var temp;

            if (!$scope.weather) {
                return 'N/A';
            }

            switch(type) {
                case 'current':
                    if ($scope.weather.windChill) {
                        temp = $scope.weather.windChill.now;
                    } else {
                        temp = $scope.weather.temperature.now;
                    }
                    break;
                case 'min':
                    temp = $scope.weather.temperature.min;
                    break;
                case 'now':
                    temp = $scope.weather.temperature.now;
                    break;
                case 'max':
                    temp = $scope.weather.temperature.max;
                    break;
            }

            return temp;
        };

        /**
         * Get the value of beaufort force
         * @returns {*}
         */
        $scope.getBeaufortForce = function()
        {
            if (!$scope.weather) {
                return '0';
            }

            return $scope.weather.windSpeed.now.beaufort.force
        };

        /**
         * Call the weather service every 'updateWeatherEveryMinutes' time
         */
        weatherChecker = $interval(function()
        {
            var now = moment();
            var diffWeather = now.diff(weatherTimestamp);
            var minutesFromLastWeather = moment.duration(diffWeather).as('minutes');

            if (minutesFromLastWeather > 60) {
                loadCurrentWeather();
            }
        }, (updateWeatherEveryMinutes * 60 * 1000));

        /**
         * Call the forecast service every 'updateForecastEveryHours' time
         */
        forecastChecker = $interval(function()
        {
            var now = moment();
            var diffForecast = now.diff(forecastTimestamp);
            var hoursFromLastForecast = moment.duration(diffForecast).as('hours');

            if (hoursFromLastForecast > 3) {
                loadCurrentForecast();
            }
        }, (updateForecastEveryHours * 60 * 60 * 1000));

        $scope.$on('$destroy', function() {
            if (angular.isDefined(weatherChecker) && angular.isDefined(forecastChecker)) {
                $interval.cancel(weatherChecker);
                $interval.cancel(forecastChecker);
                weatherChecker = undefined;
                forecastChecker = undefined;
            }
        });

        /**
         * Load current weather
         */
        var loadCurrentWeather = function()
        {
            spinner.show({id: 'weather-div'});

            weatherService.getCurrentWeather()
                .success(function(data) {
                    $scope.weather = data;
                    weatherTimestamp = moment(data.timestamp);
                })
                .error(function() {
                    $translate('WEATHER_ERROR').then(
                        function(msg) {
                            $scope.weatherError = msg;
                        }, function(msg) {
                            $scope.weatherError = msg;
                        }
                    );
                })
                .finally(function () {
                    spinner.hide('weather-div');
                })
            ;
        };

        /**
         * Load current forecast
         */
        var loadCurrentForecast = function()
        {
            spinner.show({id: 'forecast-div'});

            forecastService.getCurrentForecast()
                .success(function(data) {
                    $scope.forecast = data;
                    forecastTimestamp = moment(data.timestamp);
                })
                .error(function() {
                    $translate('FORECAST_ERROR').then(
                        function(msg) {
                            $scope.forecastError = msg;
                        }, function(msg) {
                            $scope.forecastError = msg;
                        }
                    );
                })
                .finally(function () {
                    spinner.hide('forecast-div');
                })
            ;
        };

        //call the service for the first time
        loadCurrentWeather();
        loadCurrentForecast();
    }]);