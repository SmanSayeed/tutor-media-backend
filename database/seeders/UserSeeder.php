<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'is_active' => true,
                'password' => '12345678',
            ],
            [
                'name' => 'Test User',
                'email' => 'user@gmail.com',
                'role' => 'customer',
                'is_active' => true,
                'password' => '12345678',
            ],

        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
