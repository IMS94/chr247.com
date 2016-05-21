<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine who can register users. ONly admin can register users.
     * @param User $user
     * @return bool
     */
    public function register(User $user){
        return $user->isAdmin();
    }
}

