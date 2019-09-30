<?php

namespace App\Policies;

use App\Entities\User;
use App\RBAC\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
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

    public function viewAdmin(User $user)
    {
        return $user->canDo(Permission::VIEW_ADMIN);
    }

    public function view(User $user)
    {
        return $user->canDo(Permission::CHANGE_PERMISSIONS);
    }

    public function update(User $user)
    {
        return $user->canDo(Permission::CHANGE_PERMISSIONS);
    }
}
