angular.module('dashboardApp', ['pascalprecht.translate', 'nsPopover']);

//URLs for backend
angular.module('dashboardApp').constant('FORECAST_URL', 'http://localhost/spa-clock-weather/php/forecastService.php');
angular.module('dashboardApp').constant('WEATHER_URL', 'http://localhost/spa-clock-weather/php/weatherService.php');

angular.module('dashboardApp').config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('en', translationsEN);
    $translateProvider.translations('es', translationsES);
    $translateProvider.useSanitizeValueStrategy(null);
    $translateProvider.preferredLanguage('es');
}]);