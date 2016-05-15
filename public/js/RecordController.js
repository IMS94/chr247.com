angular.module('HIS')
    .controller('RecordController', ['$scope', '$http', 'api', '$filter', '$timeout', '$window', '$rootScope',
        function ($scope, $http, api, $filter, $timeout, $window, $rootScope) {
            $scope.baseUrl = "";
            $scope.token = "";
            $scope.id = null;

            $scope.prescriptions = [];

            //to listen to the new records that are being added.
            $rootScope.$on('PrescriptionIssuedEvent', function (event, data) {
                $scope.loadMedicalRecords();
            });

            /**
             * Initial function to load records
             */
            $scope.loadMedicalRecords = function () {
                api.getMedicalRecords($scope.baseUrl, $scope.token, $scope.id).then(function (data) {
                    if (data.status == 1) {
                        $scope.prescriptions = data.prescriptions;
                    }
                });
            };
        }
    ]);