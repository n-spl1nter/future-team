<?php

namespace App\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Entities\User;

/**
 * App\RBAC\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RBAC\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RBAC\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    const MEMBER = 1;
    const ADMIN = 2;
    const MODERATOR = 3;
    const COMPANY = 4;

    const ROLE_NAME = [
        self::MEMBER => 'Пользователь',
        self::COMPANY => 'Компания',
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
