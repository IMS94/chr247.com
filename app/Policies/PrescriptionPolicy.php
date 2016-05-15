<?php

namespace App\Policies;

use App\Prescription;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrescriptionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine who can issue a prescription to the users.
     * @param User $user
     * @param Prescription $prescription
     * @return bool
     */
    public function issuePrescription(User $user, Prescription $prescription)
    {
        return $user->clinic->id === $prescription->patient->clinic->id;
    }

    /**
     * Determine who can delete a prescription. By default, only the admin can delete prescriptions
     * @param User $user
     * @param Prescription $prescription
     * @return bool
     */
    public function deletePrescription(User $user, Prescription $prescription)
    {
        return $user->isAdmin() && $user->clinic->id === $prescription->patient->clinic->id;
    }


}
