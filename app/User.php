<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * User's clinic
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic', 'clinic_id', 'id');
    }

    /**
     * User's role
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * Returns if this user is an admin
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role->role === 'Admin';
    }


    /**
     * Returns if this user is a doctor
     * @return bool
     */
    public function isDoctor()
    {
        return $this->role->role === 'Doctor';
    }

    /**
     * Returns if this user is a nurse
     * @return bool
     */
    public function isNurse()
    {
        return $this->role->role === 'Nurse';
    }


    /**
     * Get the currently signed in user
     * @return mixed
     */
    public static function getCurrentUser()
    {
        return Auth::user();
    }
}
