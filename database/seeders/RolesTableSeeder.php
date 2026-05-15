<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'admin', 'display_name' => 'Администратор'],
            ['id' => 2, 'name' => 'organization', 'display_name' => 'Организация'],
            ['id' => 3, 'name' => 'client', 'display_name' => 'Клиент'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']], // По какому полю ищем
                [
                    'name' => $role['name'],
                    'display_name' => $role['display_name'],
                    'updated_at' => now(),
                    // created_at здесь не пишем, Laravel сам разрулит это при создании
                ]
            );
        }
    }
}
