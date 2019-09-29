<?php

namespace App\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\RBAC\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RBAC\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
