<?php

namespace App\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    const VIEW_ADMIN = 'VIEW_ADMIN';
    const MODERATE_ORDERS = 'MODERATE_ORDERS';
    const CHANGE_PERMISSIONS = 'CHANGE_PERMISSIONS';
    const MANAGE_USERS = 'MANAGE_USERS';
    const MANAGE_CONTENT = 'MANAGE_CONTENT';
    const USER_ENTER = 'USER_ENTER';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id');
    }

    public function hasRole($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);
                if ($hasRole && !$require) {
                    return true;
                } else if (!$hasRole && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->roles as $role) {
                if (Str::is($name, $role->name)) {
                    return true;
                }
            }
        }
    }
}
