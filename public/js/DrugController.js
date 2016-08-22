angular.module('HIS')
    .controller('DrugController', ['$scope', '$window', 'api', 'DrugAPI',
        function ($scope, $window, api, DrugAPI) {

            $scope.predictDrug = function () {
                if (!$scope.drugName) {
                    return;
                }
                if ($scope.drugName.length != 3) {
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
            };

            $scope.getQuantityTypes = function () {
                DrugAPI.getQuantityTypes($scope.baseUrl, $scope.token).then(function (data) {
                    if (data.status == 1) {
                        $scope.quantityTypes = data.quantityTypes;
                    }
                })
            };

            $scope.save = function () {
                $scope.resetError();
                if ((!$scope.drugName || !$scope.drugName.trim()) && !$scope.drug) {
                    $scope.error.drug.has = true;
                    $scope.error.drug.msg = "Please select a drug to be added or enter a new drug";
                    $scope.error.hasError = true;
                }

                if ($scope.drugName && !$scope.quantityType) {
                    $scope.error.quantityType.has = true;
                    $scope.error.quantityType.msg = "Please enter a matching quantity type for the entered drug";
                    $scope.error.hasError = true;
                }

                if (!$scope.dosage && (!$scope.dosageText || !$scope.dosageText.trim())) {
                    $scope.error.dosage.has = true;
                    $scope.error.dosage.msg = "Please select a dosage or enter a new dosage description";
                    $scope.error.hasError = true;
                }

                if ($scope.frequencyText && !$scope.frequencyText.trim()) {
                    $scope.error.frequency.has = true;
                    $scope.error.frequency.msg = "Please enter a valid frequency description";
                    $scope.error.hasError = true;
                }
                if ($scope.periodText && !$scope.periodText.trim()) {
                    $scope.error.period.has = true;
                    $scope.error.period.msg = "Please enter a valid period description";
                    $scope.error.hasError = true;
                }

                if ($scope.error.hasError) {
                    $window.scrollTo(0, 0);
                }
            };

            $scope.resetError = function () {
                $scope.error = {
                    hasError: false,
                    frequency: {has: false},
                    dosage: {has: false},
                    period: {has: false},
                    drug: {has: false},
                    quantityType: {has: false}
                };
            }
        }
    ]);