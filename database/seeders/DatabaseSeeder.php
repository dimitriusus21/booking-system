<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,        // роли (admin, organization, client)
            CategoriesTableSeeder::class,   // категории услуг
            AdminUserSeeder::class,         // администратор
            TestServicesSeeder::class,
        ]);
    }
}
