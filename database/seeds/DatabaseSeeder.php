<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ActivityFieldsSeeder::class);
        $this->call(LangaugesSeeder::class);
        $this->call(GoalsSeeder::class);
        $this->call(OrganizationTypesSeeder::class);
    }
}
