<?php

namespace App\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\RBAC\Role;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at', 'role_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Проверяет, имеет ли пользователь права
     * @param string|string[] $permission - название разрешения или массив разрешений
     * @param bool $require - должен иметь все права или только 1 право из массива
     * @return bool
     */
    public function canDo($permission, $require = false): bool
    {
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $permRes = $this->canDo($permName);
                if($permRes && !$require){
                    return true;
                } else if (!$permRes && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->role->permissions as $perm) {
                if(Str::is($permission, $perm->name)) {
                    return true;
                }
            }
            return false;
        }
    }

    public function setRole(int $roleId)
    {
        $this->role_id = $roleId;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = \Hash::make($password);
        return $this;
    }


    public static function makeFromEmail(string $email): self
    {
        $password = Str::random(8);
        $user = new self();
        $user->email = $email;
        $user->setRole(Role::USER)
            ->setPassword($password)
            ->save();
//        $user->sendEmailVerificationNotification();
        return $user;
    }
}
