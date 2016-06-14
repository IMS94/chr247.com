<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy {
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
     * Determine who can view payment info
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user) {
        return $user->isAdmin();
    }
}
