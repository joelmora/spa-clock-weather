angular.module('dashboardApp', ['pascalprecht.translate', 'nsPopover']);

//URLs for backend
angular.module('dashboardApp').constant('FORECAST_URL', 'json/forecast.json');
angular.module('dashboardApp').constant('WEATHER_URL', 'json/weather.json');

angular.module('dashboardApp').config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('en', translationsEN);
    $translateProvider.translations('es', translationsES);
    $translateProvider.useSanitizeValueStrategy(null);
    $translateProvider.preferredLanguage('es');
}]);