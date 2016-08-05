app.controller('settingsController', ['$scope', '$translate', function($scope, $translate) {

    $scope.changeLanguage = function(lang)
    {
        $translate.use(lang);
    }

}]);