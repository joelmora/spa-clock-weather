angular.module('dashboardApp').filter('weatherFilter', function($filter) {
    return function(record, precision, showUnit) {
        if (record) {
            var output;
            precision = angular.isUndefined(precision) ? 1 : precision;
            showUnit = angular.isUndefined(showUnit) ? true : showUnit;

            if (record === 'N/A') {
                return record;
            }

            output = $filter('number')(record.value, precision);
            
            if (showUnit) {
                output += record.unit;
            }
            
            return output;
        }
    }
});
