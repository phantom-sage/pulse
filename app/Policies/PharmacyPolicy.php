<?php

namespace App\Policies;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PharmacyPolicy
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

    public function update(User $user, Pharmacy $pharmacy)
    {
        return $user->role->name === 'administrator' || $user->id === $pharmacy->user_id
        ? Response::allow()
        : Response::deny('Unauthorized operation');
    }
}
