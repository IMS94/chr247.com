/**
 * Filter to format the date
 */
angular.module('HIS')
    .filter('dateToISO', function () {
        return function (input) {
            var t = input.split(/[- :]/);
            var date = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));
            return date;
        };
    })
    .filter('exactNumber', function () {
        return function (number) {
            var num = parseInt(number, 10);
            return num.toString();
        }
    });