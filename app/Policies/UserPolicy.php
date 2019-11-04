<?php

namespace App\Policies;

use App\Entities\User;
use App\RBAC\Permission;
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

    public function setUserProfile(User $user)
    {
        return $user->canDo(Permission::SET_USER_PROFILE);
    }

    public function setCompanyProfile(User $user)
    {
        return $user->canDo(Permission::SET_COMPANY_PROFILE);
    }
}
