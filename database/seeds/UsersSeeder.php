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
        $user->email = 'admin@admin.ru';
        $user->email_verified_at = now();
        $user->password = Hash::make('f7%cH@lhP6o2b'); //$2y$10$ml89fhmN8Vg4pFSQZe97NOeXDkyrYwM/W08OtWqlH139odLS6Td6e
        $user->setRole(\App\RBAC\Role::ADMIN);
        $user->save();
    }
}
