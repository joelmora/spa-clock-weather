app.controller('calendarController', ['$scope', '$interval', function($scope, $interval) {

    var calendarInterval;

    calendarInterval = $interval(function()
    {
        //TODO
        $scope.date = moment().format('Y-M-D');
    }.bind(this), 1000);


}]);