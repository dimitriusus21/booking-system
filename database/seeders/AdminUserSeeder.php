<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Администратор',
                'email' => 'admin@mail.com',
                'password' => Hash::make('12345678'),
                'role_id' => Role::ADMIN,
                'is_active' => true,
            ]
        );

        $this->command->info('Администратор создан: admin@booking.com / 12345678');
    }
}
