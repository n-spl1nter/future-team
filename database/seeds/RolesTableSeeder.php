<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleIds = Permission::pluck('id')->toArray();

        $roleUser = new Role();
        $roleUser->name = 'USER';
        $roleUser->description = 'Пользователь';
        $roleUser->save();

        $role = new Role();
        $role->name = 'ADMIN';
        $role->description = 'Администратор';
        $role->save();
        $role->permissions()->attach($roleIds);

        $roleModerator = new Role();
        $roleModerator->name = 'MODERATOR';
        $roleModerator->description = 'Модератор';
        $roleModerator->save();
    }
}
