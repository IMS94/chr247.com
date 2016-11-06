angular.module('HIS')
    .controller('DrugController', ['$scope', '$window', 'api', 'DrugAPI', '$timeout', '$filter',
        function ($scope, $window, api, DrugAPI, $timeout, $filter) {

            $scope.predictDrug = function () {
                if (!$scope.drugName) {
                    $scope.drugPredictions = [];
                    return;
                }
                api.getDrugPredictions($scope.baseUrl, $scope.token, $scope.drugName).then(function (data) {
                    $scope.drugPredictions = data;
                });
            };

            $scope.predictIngredient = function () {
                if (!$scope.ingredient) {
                    $scope.ingredientPredictions = [];
                    return;
                }
                api.getIngredientPredictions($scope.baseUrl, $scope.token, $scope.ingredient).then(function (data) {
                    $scope.ingredientPredictions = data;
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
                });
            };

            $scope.save = function () {
                resetError();
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
                    return;
                }
                var data = {
                    drugName: $scope.drugName,
                    drug: $scope.drug,
                    quantityType: $scope.quantityType,
                    dosageText: $scope.dosageText,
                    dosage: $scope.dosage,
                    frequencyText: $scope.frequencyText,
                    frequency: $scope.frequency,
                    periodText: $scope.periodText,
                    period: $scope.period
                };

                DrugAPI.saveDrugWithDosages($scope.baseUrl, $scope.token, data).then(function (response) {
                    console.log(response);
                    if (response.status == 1) {
                        var arr = $filter('filter')($scope.prescribedDrugs, {drug: {id: response.drug.drug.id}}, false);
                        if (arr.length > 0) {
                            setError({msg: "The selected drug is already added to the prescription"});
                        } else {
                            resetData();
                            setSuccess();
                            $scope.$emit("PrescriptionDrugAddedEvent", response.drug);
                        }
                    } else {
                        setError(response);
                    }
                });
            };

            function resetError() {
                $scope.error = {
                    hasError: false,
                    msg: "Unable to add the drug. Please check entered values",
                    frequency: {has: false},
                    dosage: {has: false},
                    period: {has: false},
                    drug: {has: false},
                    quantityType: {has: false}
                };
            }

            function resetData() {
                $scope.drugName = null;
                $scope.drug = null;
                $scope.quantityType = null;
                $scope.dosageText = null;
                $scope.dosage = null;
                $scope.frequencyText = null;
                $scope.frequency = null;
                $scope.periodText = null;
                $scope.period = null;
            }

            function setError(response) {
                resetError();
                var error = $scope.error;
                error.hasError = true;
                if (response.drug || response.drugName) {
                    error.drug = {
                        has: true,
                        msg: response.drug ? response.drug[0] : response.drugName[0]
                    }
                }
                if (response.quantityType) {
                    error.quantityType = {
                        has: true,
                        msg: response.quantityType[0]
                    }
                }
                if (response.dosage || response.dosageText) {
                    error.dosage = {
                        has: true,
                        msg: response.dosage ? response.dosage[0] : response.dosageText[0]
                    }
                }
                if (response.frequency || response.frequencyText) {
                    error.frequency = {
                        has: true,
                        msg: response.frequency ? response.frequency[0] : response.frequencyText[0]
                    }
                }
                if (response.period || response.periodText) {
                    error.period = {
                        has: true,
                        msg: response.period ? response.period[0] : response.periodText[0]
                    }
                }
                if (response.msg) {
                    error.msg = response.msg;
                }
                $scope.error = error;
            }

            var timer;

            function setSuccess() {
                $scope.success = {
                    hasSuccess: true,
                    msg: "Drug added to the prescription"
                };
                timer = $timeout(function () {
                    $scope.success.hasSuccess = false;
                }, 10000);
            }
        }
    ]);