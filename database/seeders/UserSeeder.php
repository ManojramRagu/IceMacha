<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'manojram@admin.com'],
            [
                'name' => 'Manojram',
                'password' => Hash::make('123123123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // User
        User::updateOrCreate(
            ['email' => 'manojram@user.com'],
            [
                'name' => 'Manojram User',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('Users seeded: manojram@admin.com / manojram@user.com');
    }
}
