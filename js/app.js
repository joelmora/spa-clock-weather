var app = angular.module('dashboardApp', ['pascalprecht.translate']);

app.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('en', translationsEN);
    $translateProvider.translations('es', translationsES);
    $translateProvider.useSanitizeValueStrategy(null);
    $translateProvider.preferredLanguage('es');
}]);