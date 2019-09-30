<?php

use App\Entities\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.ru';
        $user->email_verified_at = now();
        $user->password = Hash::make('admin123');
        $user->setRole(\App\RBAC\Role::ADMIN);
        $user->save();
    }
}
