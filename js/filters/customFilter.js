app.filter('weatherFilter', function($filter) {
    return function(record, precision, showUnit) {
        if (record) {
            var output;
            precision = (typeof precision == 'undefined') ? 1 : precision;
            showUnit = (typeof showUnit == 'undefined') ? true : showUnit;
            output = $filter('number')(record.value, 1);
            
            if (showUnit) {
                output += record.unit;
            }
            
            return output;
        }
    }
});
