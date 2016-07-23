<?php

namespace App\Policies;

use App\Patient;
use App\Prescription;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrescriptionPolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Determine who can issue a prescription to the users.
     * @param User $user
     * @param Prescription $prescription
     * @return bool
     */
    public function issuePrescription(User $user, Prescription $prescription) {
        return $user->clinic->id === $prescription->patient->clinic->id;
    }

    /**
     * Determine who can delete a prescription. By default, only the admin can delete prescriptions
     * @param User $user
     * @param Prescription $prescription
     * @return bool
     */
    public function deletePrescription(User $user, Prescription $prescription) {
        return $user->isAdmin() && $user->clinic->id === $prescription->patient->clinic->id;
    }


    /**
     * Determines who can print prescriptions. Check whether the current user and the patient are from the same clinic.
     * Then check if the prescription's patient is the patient given.
     *
     * @param User $user
     * @param Patient $patient
     * @param Prescription $prescription
     * @return bool
     */
    public function printPrescription(User $user, Prescription $prescription, Patient $patient) {
        return $user->clinic->id === $patient->clinic->id && $prescription->patient->id === $patient->id;
    }


}
