<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DosagePolicy
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
     * Any user can add dosages.
     * @param User $user
     * @return bool
     */
    public function add(User $user)
    {
        return true;
    }

    /**
     * Only a dosage of the same clinic can be viewed by a user
     * @param User $user
     * @param $dosage
     * @return bool
     */
    public function view(User $user, $dosage)
    {
        return $user->clinic->id === $dosage->clinic->id;
    }


    /**
     * Define who can edit the dosage details.
     * @param User $user
     * @param $dosage
     * @return bool
     */
    public function edit(User $user, $dosage)
    {
        return $user->clinic->id === $dosage->clinic->id && !$user->isNurse();
    }


    /**
     * only the admin can delete a dosage
     * @param User $user
     * @param $dosage
     * @return bool
     */
    public function delete(User $user, $dosage)
    {
        return $user->isAdmin() && $user->clinic->id === $dosage->clinic->id;
    }
}
