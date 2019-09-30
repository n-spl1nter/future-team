<?php

use App\RBAC\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = Permission::VIEW_ADMIN;
        $permission->description = 'Просмотр админки';
        $permission->save();

        $permission2 = new Permission();
        $permission2->name = Permission::MODERATE_ORDERS;
        $permission2->description = 'Модерирование заявок';
        $permission2->save();

        $permission3 = new Permission();
        $permission3->name = Permission::CHANGE_PERMISSIONS;
        $permission3->description = 'Изменение прав';
        $permission3->save();

        $permission3 = new Permission();
        $permission3->name = Permission::MANAGE_USERS;
        $permission3->description = 'Управление пользователями';
        $permission3->save();
    }
}
