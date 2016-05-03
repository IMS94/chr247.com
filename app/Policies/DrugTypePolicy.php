<?php

namespace App\Policies;

use App\Clinic;
use App\DrugType;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrugTypePolicy
{
    use HandlesAuthorization;

    /**
     * DrugTypePolicy constructor.
     */
    public function __construct()
    {
        //
    }


    /**
     * Anyone can add drug types
     * @param User $user
     * @return bool
     */
    public function add(User $user)
    {
        return true;
    }

    /**
     * Only admin can delete drug types
     * @param User $user
     * @param DrugType $drugType
     * @return bool
     */
    public function delete(User $user, DrugType $drugType)
    {
        return $user->isAdmin() && $user->clinic->id === $drugType->clinic->id;
    }
}
