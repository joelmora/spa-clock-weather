app.controller('meteorologyController', ['$scope', 'weatherService', 'forecastService', '$interval', function($scope, weatherService, forecastService, $interval)
{
    var weatherTimestamp, forecastTimestamp;
    var weatherChecker, forecastChecker;
    var updateWeatherEveryMinutes = 5;
    var updateForecastEveryHours = 24;

    //weather
    this.loadCurrentWeather = function()
    {
        weatherService.getCurrentWeather().success(function(data) {
            $scope.weather = data;
            weatherTimestamp = moment(data.timestamp);
        });
    };

    //forecast
    this.loadCurrentForecast = function()
    {
        forecastService.getCurrentForecast().success(function(data) {
            $scope.forecast = data;
            forecastTimestamp = moment(data.expireOn);
        });
    };

    //call the service for the first time
    this.loadCurrentWeather();
    this.loadCurrentForecast();

    //clicks
    $scope.updateMeteorology = function()
    {
        this.loadCurrentWeather();
        this.loadCurrentForecast();
    }.bind(this);

    //call the weather service every 'updateWeatherEveryMinutes' time
    weatherChecker = $interval(function()
    {
        var now = moment();
        var diffWeather = now.diff(weatherTimestamp);
        var minutesFromLastWeather = moment.duration(diffWeather).as('minutes');

        if (minutesFromLastWeather > 60) {
            this.loadCurrentWeather();
        }
    }.bind(this), (updateWeatherEveryMinutes * 60 * 1000));

    //call the forecast service every 'updateForecastEveryHours' time
    forecastChecker = $interval(function()
    {
        var now = moment();
        var diffForecast = now.diff(forecastTimestamp);
        var hoursFromLastForecast = moment.duration(diffForecast).as('hours');

        if (hoursFromLastForecast > 24) {
            this.loadCurrentForecast();
        }
    }.bind(this), (updateForecastEveryHours * 60 * 60 * 1000));

    $scope.$on('$destroy', function() {
        if (angular.isDefined(weatherChecker) && angular.isDefined(forecastChecker)) {
            $interval.cancel(weatherChecker);
            $interval.cancel(forecastChecker);
            weatherChecker = undefined;
            forecastChecker = undefined;
        }
    });
}]);