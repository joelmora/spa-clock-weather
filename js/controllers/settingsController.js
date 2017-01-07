angular.module('dashboardApp').controller('settingsController',
    ['$scope', '$translate', function($scope, $translate) {

        /**
         * Change language
         * @param lang
         */
        $scope.changeLanguage = function(lang)
        {
            $translate.use(lang);
        };

        /**
         * Check if lang match the current language 
         * @param lang
         * @returns {boolean}
         */
        $scope.isLang = function(lang)
        {
            return $translate.use() == lang;
        };

    }]);