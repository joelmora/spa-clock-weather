angular.module('dashboardApp').factory('spinnerService',
    function() {

        var defaultOptions = {
            effect : 'ios',
            text : '',
            bg : 'rgba(255, 255, 255, 0.5)',
            color : '#333'
        };

        /**
         * Activate the spinner on the id given and with the options
         * @param params
         */
        function showSpinner(params)
        {
            var options = angular.extend({}, defaultOptions, params);

            $('#' + params.id).waitMe(options);
        }

        /**
         * Hide the spinner with the id fiven
         * @param id
         */
        function hideSpinner(id)
        {
            $('#' + id).waitMe('hide');
        }

        return {
            'show': showSpinner,
            'hide': hideSpinner
        };
    });