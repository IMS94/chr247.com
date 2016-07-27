<?php

namespace App\Policies;

use App\Stock;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockPolicy {
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
     * Nurses cannot add stocks.
     * @param User $user
     * @return bool
     */
    public function add(User $user) {
        return true;
    }

    /**
     * Only admin can delete a stock
     * @param User $user
     * @param Stock $stock
     * @return bool
     */
    public function delete(User $user, Stock $stock) {
        return $user->isAdmin() && $user->clinic->id === $stock->drug->clinic->id;
    }

    /**
     * Get who can view the stocks that are running low
     *
     * @param User $user
     * @return bool
     */
    public function seeRunningLow(User $user) {
        return true;
    }
}
