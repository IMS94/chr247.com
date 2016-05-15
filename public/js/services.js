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
                return $http.post(baseUrl + "/API/drugs/", {
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
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : [];
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
                return $http.post(baseUrl + "/API/getMedicalRecords/"+patientId, {
                    _token: token
                }).then(function (response) {
                    return response.data;
                }, function (response) {
                    return response.data ? response.data : {status: 0};
                });
            }
        };
    }]);