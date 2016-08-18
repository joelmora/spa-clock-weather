app.controller('calendarController', ['$scope', '$interval', function($scope, $interval) {

    var calendarInterval;

    this.updateCalendar = function()
    {
        $scope.day = moment().format('DD');
        $scope.month = moment().format('MMM');
        $scope.weekday = moment().format('dddd');
        
        $scope.hour = moment().format('H:mm');
    };

    calendarInterval = $interval(function()
    {
        this.updateCalendar();
    }.bind(this), 1000);

    this.updateCalendar();
}]);