<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
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
     * Determine who can register users. ONly admin can register users.
     *
     * @param User $user
     * @return bool
     */
    public function register(User $user) {
        return $user->isAdmin();
    }

    /**
     * Determine who can delete user accounts.
     *
     * @param User $actor
     * @param User $target
     * @return bool
     */
    public function delete(User $actor, $target) {
        if (is_null($target) || !$target instanceof User) {
            return $actor->isAdmin();
        }
        return $actor->id != $target->id && $actor->isAdmin() && !$target->isAdmin()
        && $target->clinic->id == $actor->clinic->id;
    }
}

