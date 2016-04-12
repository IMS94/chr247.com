<?php

namespace App\Policies;

use App\Patient;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
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
     * Can the user get a patient's information
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function view(User $user, Patient $patient)
    {
        return $user->clinic->id === $patient->clinic->id;
    }


    /**
     * Edit policy. Only a person from the same clinic can edit
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function edit(User $user, Patient $patient)
    {
        return $user->clinic->id === $patient->clinic->id;
    }

    /**
     * Only an admin can delete a patient
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function delete(User $user, Patient $patient)
    {
        return $user->isAdmin() && $user->clinic->id === $patient->clinic->id;
    }
}
