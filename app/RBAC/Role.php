<?php

namespace App\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Entities\User;

class Role extends Model
{
    const USER = 1;
    const ADMIN = 2;
    const MODERATOR = 3;

    const ROLE_NAME = [
        self::USER => 'Пользователь',
        self::ADMIN => 'Администратор',
        self::MODERATOR => 'Модератор',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    /**
     * Проверяет имеет ли роль переданные права
     * @param array|string $name - названия прав
     * @param bool $require - Роль должна иметь все права из переданных
     * @return bool
     */
    public function hasPermission($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasPermission = $this->hasPermission($roleName);
                if ($hasPermission && !$require) {
                    return true;
                } else if (!$hasPermission && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->permissions as $permission) {
                if (Str::is($name, $permission->name)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Сохраняет разрешения для определенной роли
     * @param array $permissions - массив с id разрешений
     */
    public function savePermissions($permissions)
    {
        if(!empty($permissions)){
            $this->permissions()->sync($permissions);
        }else{
            $this->permissions()->detach();
        }
    }

}
