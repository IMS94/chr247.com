angular.module('HIS')
    .controller('DrugController', ['$scope', 'api', '$interval', '$filter', '$timeout', '$window',
        function ($scope, api, $interval, $filter, $timeout) {

            $scope.predictDrug = function () {
                if ($scope.drugName && $scope.drugName.length != 3) {
                    return;
                }
                api.getDrugPredictions($scope.baseUrl, $scope.token, $scope.drugName).then(function (data) {
                    $scope.drugPredictions = data;
                });
            };

            /**
             * Predict the manufacturer when there are 2 letters in the input
             */
            $scope.predictManufacturer = function () {
                if ($scope.manufacturer && $scope.manufacturer.length != 2) {
                    return;
                }
                api.getManufacturerPredictions($scope.baseUrl, $scope.token, $scope.manufacturer).then(function (data) {
                    $scope.manufacturers = data;
                });
            }
        }
    ]);