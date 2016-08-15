angular.module('HIS')
    .controller('IssueMedicineController', ['$scope', '$http', 'api', '$filter',
        '$timeout', '$window', '$interval', '$rootScope',
        function ($scope, $http, api, $filter, $timeout, $window, $interval, $rootScope) {

            //data for api
            $scope.baseUrl = "";
            $scope.token = "";
            $scope.id = null;

            //prescriptions array
            $scope.prescriptions = [];

            //error
            $scope.error = "";
            $scope.hasSuccess = false;
            $scope.successMessage = "";


            $rootScope.$on('prescriptionAddedEvent', function (event, data) {
                $scope.loadPrescriptions();
            });

            /**
             * Load the prescriptions of a given patient when the page loads
             */
            $scope.loadPrescriptions = function () {
                api.getPrescriptions($scope.baseUrl, $scope.token, $scope.id).then(function (data) {
                    if (data && data.status == 1) {
                        $scope.prescriptions = data.prescriptions;
                    }
                });
            };


            /**
             * Get the available stock count of a drug when the user is inputting issuedQuantity value
             *
             * Data Format  -   {prescriptionId: xx, drugs: []}
             * drugs are sent as an array of indexes.
             * @param index the index at which the prescription is placed in the UI.
             */
            $scope.checkStockAvailability = function (index) {
                var data = {prescriptionId: $scope.prescriptions[index].id, drugs: []};
                if ($scope.prescriptions[index].hasOwnProperty("prescription_drugs")) {
                    for (x in $scope.prescriptions[index].prescription_drugs) {
                        var p = $scope.prescriptions[index].prescription_drugs[x];
                        data.drugs.push(p.drug.id);
                    }
                }

                api.checkStockAvailability($scope.baseUrl, $scope.token, data)
                    .then(function (data) {
                        if (data.status == 1) {
                            for (x in $scope.prescriptions[index].prescription_drugs) {
                                for (y in data.stocks) {
                                    if ($scope.prescriptions[index].prescription_drugs[x].drug.id == data.stocks[y].id) {

                                        $scope.prescriptions[index].prescription_drugs[x].outOfStocks =
                                            $scope.prescriptions[index].prescription_drugs[x].issuedQuantity
                                            > data.stocks[y].quantity;

                                        $scope.prescriptions[index].prescription_drugs[x]
                                            .drug.quantity = data.stocks[y].quantity;
                                        break;
                                    }
                                }
                            }

                        }
                    });
            };

            /**
             * This function is called when issue prescription is clicked.
             * Each drug should have the quantity set.
             * @param prescriptionId
             */
            $scope.issuePrescription = function (index) {
                var prescription = $scope.prescriptions[index];
                if (!prescription) {
                    $window.alert("Invalid Prescription");
                    return;
                }
                prescription.hasError = false;

                //check if each drug is set with a valid quantity entry
                var valid = true;
                for (x in prescription.prescription_drugs) {
                    if (!angular.isNumber(prescription.prescription_drugs[x].issuedQuantity)) {
                        valid = false;
                    }
                }

                if (!angular.isNumber(prescription.payment)) {
                    $scope.showError("Please enter the payment for this prescription. (Enter 0 if none)", prescription);
                }
                else if (prescription.payment < 0) {
                    $scope.showError("Please enter a valid amount for payment", prescription);
                }
                if (!prescription.paymentRemarks) {
                    prescription.paymentRemarks = "";
                }
                if (valid) {
                    api.issuePrescription($scope.baseUrl, $scope.token, prescription).then(function (data) {
                        //show success if status is 1
                        if (data && data.status == 1) {
                            $scope.showSuccess("Prescription marked as issued");
                            $scope.$emit('PrescriptionIssuedEvent', []);
                        }
                        else {
                            //show error message
                            $scope.showError(data && data.message ? data.message : "Unable to mark as issued",
                                prescription);
                            //if the status is -1, then the prescription is already issued.
                            // The message will be shown and then the data will be reloaded.
                            if (data.status == -1) {
                                $timeout(function () {
                                    $scope.loadPrescriptions();
                                }, 2000);
                            }
                        }
                    });
                }
                else {
                    $scope.showError("Please enter issued quantities of all the drugs in this prescription", prescription);
                }
            };

            /**
             * Helper method to show an error. An error will be visible for 5 seconds
             * @param message
             */
            $scope.showError = function (message, prescription) {
                $scope.error = message;
                prescription.hasError = true;
                $timeout(function () {
                    prescription.hasError = false;
                }, 6000);
            };


            /**
             * Helper method to show a success.
             * @param message
             */
            $scope.showSuccess = function (message) {
                $scope.hasSuccess = true;
                $scope.successMessage = message;
                $window.scrollTo(0, 0);
                $scope.loadPrescriptions();
                $timeout(function () {
                    $scope.hasSuccess = false;
                }, 6000);
            };


            /**
             * Deletes a prescription.The prescription will be deleted only if the user is authorized.
             * @param index
             */
            $scope.deletePrescription = function (index) {
                var prescription = $scope.prescriptions[index];
                if (prescription && $window.confirm("Are you sure to delete this prescription")) {
                    api.deletePrescription($scope.baseUrl, $scope.token, prescription).then(function (data) {
                        if (data.status == 1) {
                            $scope.showSuccess("Prescription deleted successfully");
                        }
                        else {
                            //show error message
                            $scope.showError(data && data.message ? data.message : "Unable to delete the prescription",
                                prescription);
                        }
                    });
                }
            }
        }]
    );


