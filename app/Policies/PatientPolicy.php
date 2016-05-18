<?php

namespace App\Policies;

use App\Patient;
use App\Queue;
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


    /**
     * Permissions to issue an ID
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function issueID(User $user, Patient $patient)
    {
        return $user->clinic->id === $patient->clinic->id;
    }


    public function issueMedical(User $user, Patient $patient)
    {
        return $user->isDoctor() && $user->clinic->id === $patient->clinic->id;
    }


    /**
     * Determine who can prescribe medicine for a given patient.
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function prescribeMedicine(User $user, Patient $patient)
    {
        return !$user->isNurse() && $user->clinic->id === $patient->clinic->id;
    }


    /**
     * Determine who can issue medicine to a patient.
     * By default, anyone can issue medicine to a patient
     * @param User $user
     * @return bool
     */
    public function issueMedicine(User $user)
    {
        return true;
    }


    /**
     * Determine who can prescribe medicine for a given patient.
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function viewPrescriptions(User $user, Patient $patient)
    {
        return $user->clinic->id === $patient->clinic->id;
    }

    /**
     * Determine who can view the medical records of a given patient.
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function viewMedicalRecords(User $user, Patient $patient)
    {
        return !$user->isNurse() && $user->clinic->id === $patient->clinic->id;
    }


    /**
     * Determine who can add patients to the queue
     * @param User $user
     * @param Patient $patient
     * @return bool
     */
    public function addToQueue(User $user, Patient $patient)
    {
        $queue = Queue::getCurrentQueue();
        if (!empty($queue) && $queue->patients()->wherePivot('completed', false)->find($patient->id) != null) {
            return false;
        }
        return true;
    }

}
