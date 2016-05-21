angular.module('HIS')
    .controller('ClinicRegistrationController', ['$scope', 'api',
        function ($scope, api) {
            $scope.timezones = [];
            $scope.countryCode = "";

            /**
             * Get thetimezones by country
             */
            $scope.getTimezones = function () {
                if (!$scope.countryCode) {
                    return;
                }
                api.getTimezones($scope.baseUrl, $scope.token, $scope.countryCode).then(function (data) {
                    $scope.timezones = data;
                });
            };

            //call when loading
            $scope.getTimezones();
        }
    ]);