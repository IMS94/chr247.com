<?php

namespace App\Policies;

use App\Drug;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class DrugPolicy
{
    use HandlesAuthorization;

    /**
     * DrugPolicy constructor.
     */
    public function __construct()
    {
        //
    }


    /**
     * Nurses cannot add drug types.
     * @param User $user
     * @param $class
     * @return bool
     */
    public function add(User $user,$class){
        Log::info($class);
        return $user->isAdmin() || $user->isDoctor();
    }

    /**
     * Only a drug of the same clinic can be viewed by a user
     * @param User $user
     * @param Drug $drug
     * @return bool
     */
    public function view(User $user,Drug $drug){
        return $user->clinic->id===$drug->clinic->id;
    }


    /**
     * only the admin can delete a drug
     * @param User $user
     * @param Drug $drug
     * @return bool
     */
    public function delete(User $user, Drug $drug){
        return $user->isAdmin() && $user->clinic->id === $drug->clinic->id;
    }
}
