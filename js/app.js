var app = angular.module('dashboardApp', []);

app.filter('weatherFilter', function() {
    return function(record) {
        if (record) {
            var output;
            output = record.value +  record.unit;
            return output;
        }
    }
});