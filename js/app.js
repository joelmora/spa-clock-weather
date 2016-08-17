var app = angular.module('dashboardApp', ['pascalprecht.translate']);

app.filter('weatherFilter', function($filter) {
    return function(record) {
        if (record) {
            var output;
            output = $filter('number')(record.value, 1) +  record.unit;
            return output;
        }
    }
});

app.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('en', translationsEN);
    $translateProvider.translations('es', translationsES);
    $translateProvider.useSanitizeValueStrategy(null);
    $translateProvider.preferredLanguage('en');
}]);