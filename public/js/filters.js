/**
 * Filter to format the date
 */
angular.module('HIS')
    .filter('dateToISO', function () {
        return function (input) {
            var offset = new Date().getTimezoneOffset();
            var date = new Date(input);
            date.setTime(date.getTime()-offset*60000);
            return date;
        };
    });