angular.module('HIS')
    .controller('QueueController', ['$scope', 'api', '$interval', '$filter', '$timeout', '$window',
        function ($scope, api, $interval, $filter, $timeout, $window) {
            $scope.patients = [];

            $scope.baseUrl = "";
            $scope.token = "";

            $scope.hasError = false;
            $scope.error = "";
            $scope.errorTimeout = null;

            /**
             * Get the queue through API when initializing
             */
            $scope.getQueue = function () {
                api.getQueue($scope.baseUrl, $scope.token).then(function (data) {
                    if (data.status == 1) {
                        $scope.patients = data.patients;
                        for (x in $scope.patients) {
                            if ($scope.patients[x].pivot.inProgress == 0) {
                                $scope.patients[x].status = "Waiting ...";
                                $scope.patients[x].type = 0;
                            }
                            else {
                                $scope.patients[x].status = "In Progress";
                                $scope.patients[x].type = 1;
                            }
                        }
                    }
                });
            };

            /**
             * Updates the queue when a patient is clicked to be updated.
             * @param index
             */
            $scope.updateQueue = function (index) {
                var result = $filter('filter')($scope.patients, {pivot: {inProgress: 1}}, false);
                var accepted = false;
                if ($scope.patients[index].pivot.inProgress == 0 && result.length > 0) {
                    //show error
                    $scope.showError("There's already a patient in progress." +
                        " Please mark him/her as completed before continue.");
                } else if ($scope.patients[index].pivot.inProgress == 0) {
                    //send request
                    accepted = true;
                    $scope.patients[index].pivot.inProgress = 1;
                    $scope.patients[index].pivot.type = 1;
                    $scope.patients[index].status = "In Progress";
                }
                else if ($scope.patients[index].pivot.inProgress == 1) {
                    accepted = true;
                    $scope.patients[index].pivot.inProgress = 2;
                    $scope.patients[index].pivot.type = 2;
                    $scope.patients[index].status = "Completed";
                }
                if (accepted && $window.confirm("Are you sure to update queue?")) {
                    api.updateQueue($scope.baseUrl, $scope.token, $scope.patients[index]).then(function (data) {
                        if (data.status == 1) {
                            $scope.getQueue();
                        }
                        else if (data.status == 0 && data.message) {
                            $scope.showError(data.message);
                        }
                    });
                }
            };


            $scope.enter = function (index) {
                if ($scope.patients[index].pivot.inProgress == 0) {
                    //waiting
                    $scope.patients[index].status = "In Progress ?";
                    $scope.patients[index].type = 1;
                }
                else if ($scope.patients[index].pivot.inProgress == 1) {
                    //in progress
                    $scope.patients[index].status = "Completed ?";
                    $scope.patients[index].type = 2;
                }
            };

            $scope.leave = function (index) {
                if ($scope.patients[index].pivot.inProgress == 0) {
                    //waiting
                    $scope.patients[index].status = "Waiting ...";
                    $scope.patients[index].type = 0;
                }
                else if ($scope.patients[index].pivot.inProgress == 1) {
                    //in progress
                    $scope.patients[index].status = "In Progress";
                    $scope.patients[index].type = 1;
                }
            };


            /**
             * Helper method to show an error. An error will be visible for 5 seconds
             * @param message
             */
            $scope.showError = function (message) {
                $scope.error = message;
                $scope.hasError = true;
                $window.scrollTo(0, 0);
                $timeout.cancel($scope.errorTimeout);
                $scope.errorTimeout = $timeout(function () {
                    $scope.hasError = false;
                }, 6000);
            };

            $interval(function () {
                $scope.getQueue();
            }, 60000);
        }
    ]);