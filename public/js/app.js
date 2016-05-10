var app = angular.module('HIS', [], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    })
    .controller('PrescriptionController', ['$scope', '$http', 'api', function ($scope, $http, api) {
        $scope.drugs = [];
        $scope.dosages = [];
        $scope.frequencies = [];
        $scope.periods = [];

        $scope.drug = null;
        $scope.period = null;
        $scope.frequency = null;
        $scope.dosage = null;

        $scope.baseUrl = "";
        $scope.token = "";

        $scope.init = function () {
            api.getDrugs($scope.baseUrl, $scope.token).then(function (drugs) {
                $scope.drugs = drugs;
            });

            api.getDosages($scope.baseUrl, $scope.token).then(function (data) {
                if (data != null) {
                    $scope.dosages = data.dosages;
                    $scope.frequencies = data.frequencies;
                    $scope.periods = data.periods;
                    console.log($scope.dosages);
                    console.log($scope.frequencies);
                    console.log($scope.periods);
                }
            });
        }

        $scope.add = function () {
            console.log($scope.drug+" "+$scope.dosage+" "+$scope.frequency+" "+$scope.period);
        }

    }])
    .service('api', ['$http', function ($http) {
        return {
            /**
             * Get the drugs from the server
             * @param url
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

