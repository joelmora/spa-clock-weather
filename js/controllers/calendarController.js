angular.module('dashboardApp').controller('calendarController',
    ['$scope', '$interval', function($scope, $interval) {

        var calendarInterval;
        var updateCalendar;

        /**
         * Get current time and assign the data to scope
         */
        updateCalendar = function()
        {
            $scope.day = moment().format('DD');
            $scope.month = moment().format('MMM');
            $scope.weekday = moment().format('dddd');

            $scope.hour = moment().format('H:mm');
        };

        /**
         * Update calendar every second
         */
        calendarInterval = $interval(function()
        {
            updateCalendar();
        }, 1000);

        updateCalendar();
    }]);