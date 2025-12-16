<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@fisika.com'],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@fisika.com',
                'password' => Hash::make('password'), // untuk testing
                'is_admin' => true,
                'is_super_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Regular Admin
        User::updateOrCreate(
            ['email' => 'admin@fisika.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@fisika.com',
                'password' => Hash::make('password'), // untuk testing
                'is_admin' => true,
                'is_super_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->info('Super Admin - Email: superadmin@fisika.com, Password: password');
        $this->command->info('Regular Admin - Email: admin@fisika.com, Password: password');
    }
} 
 