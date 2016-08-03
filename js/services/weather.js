app.factory('weather', ['$http', function($http) {
    return $http.get('http://localhost/joelmora/clock/php/weather.php')
        .success(function(result) {
            return result;
        })
        .error(function(err) {
            return err;
        });
}]);