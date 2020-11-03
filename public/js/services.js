angular.module('HIS', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
})
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
                    return {
                        status: 0
                    };
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
            },


            /**
             * Save a prescription by sending to the server.
             * @param baseUrl
             * @param data
             * @returns {*}
             */
            savePrescription: function (baseUrl, data) {
                return $http.post(baseUrl + "/API/savePrescription", data).then(
                    function (response) {
                        return response.data;
                    }, function (response) {
                        return response.data;
                    }
                );
            },


            /**
             * Get all the prescriptions belonging to a patient
             * @param baseUrl
             * @param token
             * @param id
             * @returns {*}
             */
            getPrescriptions: function (baseUrl, token, id) {
                return $http.post(baseUrl + "/API/getPrescriptions/" + id, {
                    _token: token
                }).then(function (response) {
                    //console.log(response.data);
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : [];
                });
            },

            /**
             * Get all the prescriptions belonging to a patient
             * @param baseUrl
             * @param token
             * @param id
             * @returns {*}
             */
            getAllPrescriptions: function (baseUrl, token) {
                return $http.post(baseUrl + "/API/getAllPrescriptions", {
                    _token: token
                }).then(function (response) {
                    //console.log(response.data);
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : [];
                });
            },

            checkStockAvailability: function (baseUrl, token, data) {
                return $http.post(baseUrl + "/API/checkStocksAvailability", {
                    _token: token,
                    data: data
                }).then(function (response) {
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : {status: 0};
                });
            },

            /**
             * Issue a prescription to the patient
             * @param baseUrl
             * @param token
             * @param prescription
             * @returns {*}
             */
            issuePrescription: function (baseUrl, token, prescription) {
                return $http.post(baseUrl + "/API/issuePrescription", {
                    _token: token,
                    prescription: prescription
                }).then(function (response) {
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : {status: 0};
                });
            },

            /**
             * Deletes a prescription only if authorized
             * @param baseUrl
             * @param token
             * @param prescription
             * @returns {*}
             */
            deletePrescription: function (baseUrl, token, prescription) {
                return $http.post(baseUrl + "/API/deletePrescription/" + prescription.id, {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : {status: 0};
                });
            },

            /**
             * Get the medical records of a patient
             * @param baseUrl
             * @param token
             * @param patientId
             * @returns {*}
             */
            getMedicalRecords: function (baseUrl, token, patientId) {
                return $http.post(baseUrl + "/API/getMedicalRecords/" + patientId, {
                    _token: token
                }).then(function (response) {
                    //console.log(response.data);
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : {status: 0};
                });
            },

            /**
             * Get the current queue of the clinic
             * @param baseUrl
             * @param token
             * @returns {*}
             */
            getQueue: function (baseUrl, token) {
                return $http.post(baseUrl + "/API/getQueue", {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : {status: 0};
                });
            },

            updateQueue: function (baseUrl, token, patient) {
                return $http.post(baseUrl + "/API/updateQueue", {
                    _token: token,
                    patient: patient
                }).then(function (response) {
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : {status: 0};
                });
            },

            /**
             * Get the timezones based on the country code.
             * All the timezones in that country will be returned.
             *
             * @param baseUrl
             * @param token
             * @param countryCode
             * @returns {*}
             */
            getTimezones: function (baseUrl, token, countryCode) {
                return $http.post(baseUrl + "/API/support/timezones/" + countryCode, {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function (response) {
                    return [];
                });
            },

            /**
             * Predicts drug name from a partially typed drug name.
             * Calls the REST API.
             *
             * @param baseUrl
             * @param token
             * @param text
             * @returns {*}
             */
            getDrugPredictions: function (baseUrl, token, text) {
                return $http.post(baseUrl + "/API/support/drugPredictions/" + text, {
                    _token: token
                }).then(function (response) {
                    return response.data.drugs;
                }, function (response) {
                    return [];
                });
            },

            /**
             * Predicts drug ingredient from a partially typed drug name.
             * Calls the REST API.
             *
             * @param baseUrl
             * @param token
             * @param text
             * @returns {*}
             */
            getIngredientPredictions: function (baseUrl, token, text) {
                return $http.post(baseUrl + "/API/support/ingredientPredictions/" + text, {
                    _token: token
                }).then(function (response) {
                    return response.data.ingredients;
                }, function (response) {
                    return [];
                });
            },

            /**
             * Get the manufacturer name predictions based on partially typed manufaturer's name.
             *
             * @param baseUrl
             * @param token
             * @param text
             * @returns {*}
             */
            getManufacturerPredictions: function (baseUrl, token, text) {
                return $http.post(baseUrl + "/API/support/manufacturerPredictions/" + text, {
                    _token: token
                }).then(function (response) {
                    return response.data.manufacturers;
                }, function (response) {
                    return [];
                });
            },

            getDiseasePredictions: function (baseUrl, token, text) {
                return $http.post(baseUrl + "/API/support/diseasePredictions/" + text, {
                    _token: token
                }).then(function (response) {
                    return response.data.diseases;
                }, function (response) {
                    return [];
                });
            }
        };
    }])
    .service('DrugAPI', ['$http', function ($http) {
        return {
            getDosages: function (baseUrl, token) {
                return $http.post(baseUrl + "/API/getDosages", {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function () {
                    return {
                        status: 0
                    };
                });
            },

            getFrequencies: function (baseUrl, token) {
                return $http.post(baseUrl + "/API/getFrequencies", {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function () {
                    return {
                        status: 0
                    };
                });
            },

            getPeriods: function (baseUrl, token) {
                return $http.post(baseUrl + "/API/getPeriods", {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function () {
                    return {
                        status: 0
                    };
                });
            },

            getQuantityTypes: function (baseUrl, token) {
                return $http.post(baseUrl + "/API/getQuantityTypes", {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function () {
                    return {
                        status: 0
                    };
                });
            },

            /**
             * Save a drug with it's quantity type and add corresponding dosages and frequencies.
             * The result will be a drug to be added to the prescription.
             *
             * @param baseUrl Base URL
             * @param token CSRF Token
             * @param data  Drug and dosage details to be sent
             * @returns {*} response
             */
            saveDrugWithDosages: function (baseUrl, token, data) {
                data._token = token;
                return $http.post(baseUrl + "/API/saveDrugWithDosages", data)
                    .then(function (response) {
                        return response.data;
                    }, function () {
                        return {
                            status: 0
                        };
                    });
            }
        };
    }]);