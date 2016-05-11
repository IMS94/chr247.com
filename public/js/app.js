var app;

app = angular.module('HIS', [], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    })
    .controller('PrescriptionController', ['$scope', '$http', 'api', '$filter', '$timeout',
        function ($scope, $http, api, $filter, $timeout) {
            $scope.drugs = [];
            $scope.dosages = [];
            $scope.frequencies = [];
            $scope.periods = [];

            //things to be submitted
            $scope.prescribedDrugs = [];
            $scope.complaints="";
            $scope.investigations="";
            $scope.diagnosis="";
            $scope.remarks="";

            $scope.drug = null;
            $scope.period = null;
            $scope.frequency = null;
            $scope.dosage = null;

            $scope.baseUrl = "";
            $scope.token = "";

            //for error handling
            $scope.hasDrugError = false;
            $scope.error = "";


            //to measure the timeout of errors
            $scope.drugErrorTimeout=null;


            /**
             * Init function. loads relevant data from the API
             */
            $scope.init = function () {
                api.getDrugs($scope.baseUrl, $scope.token).then(function (drugs) {
                    $scope.drugs = drugs;
                });

                api.getDosages($scope.baseUrl, $scope.token).then(function (data) {
                    if (data != null) {
                        $scope.dosages = data.dosages;
                        $scope.frequencies = data.frequencies;
                        $scope.periods = data.periods;
                    }
                });
            };


            /**
             * Adds a drug to the prescribed drugs list. At least a drug and an dosage has to be selected.
             */
            $scope.add = function () {
                var d, dose, frequency, period;

                //initially check whether a drug/dosage is selected
                if (!$scope.drug || !$scope.dosage) {
                    $scope.showDrugError("You must select a drug and a dosage to add to the prescription");
                    return;
                }

                //search for the selected drug, frequency, dosage and period.
                if ($scope.drug) {
                    d = $filter('filter')($scope.drugs, {id: $scope.drug}, false);
                }
                if ($scope.dosage) {
                    dose = $filter('filter')($scope.dosages, {id: $scope.dosage}, false);
                }
                if ($scope.frequency) {
                    frequency = $filter('filter')($scope.frequencies, {id: $scope.frequency}, false);
                }
                if ($scope.period) {
                    period = $filter('filter')($scope.periods, {id: $scope.period}, false);
                }

                //check if the selected drug is already added to the list.
                var arr = $filter('filter')($scope.prescribedDrugs, {drug: {id: d[0].id}}, false);
                if (arr.length > 0) {
                    $scope.showDrugError("Drug already added to the prescription");
                    return;
                }

                $scope.prescribedDrugs.push(
                    {
                        drug: d[0],
                        dose: dose[0],
                        frequency: frequency && frequency.length > 0 ? frequency[0] : null,
                        period: period && period.length > 0 ? period[0] : null,
                        type: 1
                    }
                );
            };


            /**
             * Helper method to show an error. An error will be visible for 5 seconds
             * @param message
             */
            $scope.showDrugError = function (message) {
                $scope.error = message;
                $scope.hasDrugError = true;
                $timeout.cancel($scope.drugErrorTimeout);
                $scope.drugErrorTimeout = $timeout(function () {
                    $scope.hasDrugError = false;
                }, 5000);
            };


            /**
             * Remove a prescribed drug from the list
             * @param index
             */
            $scope.removeDrug = function (index) {
                $scope.prescribedDrugs.splice(index, 1);
            }

        }])
    .service('api', ['$http', function ($http) {
        return {
            /**
             * Get the drugs from the server
             * @param baseUrl
             * @param token
             * @returns {*}
             */
            getDrugs: function (baseUrl, token) {
                return $http.post(baseUrl + "/API/drugs", {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function () {
                    return [];
                });
            },

            /**
             * Get the dosages from API
             * @param baseUrl
             * @param token
             * @returns {*}
             */
            getDosages: function (baseUrl, token) {
                return $http.post(baseUrl + "/API/dosages", {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function () {
                    return null;
                });
            }
        };
    }]);

