<?php

namespace Database\Seeders;

use App\Enums\UserRolesEnum;
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
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => UserRolesEnum::ADMIN,
                'password' => '12345678',
            ],
            [
                'name' => 'Guardian User',
                'username' => 'guardian',
                'email' => 'guardian@gmail.com',
                'role' => UserRolesEnum::GUARDIAN,
                'password' => '12345678',
            ],
            [
                'name' => 'Tutor User',
                'username' => 'tutor',
                'email' => 'tutor@gmail.com',
                'role' => UserRolesEnum::TUTOR,
                'password' => '12345678',
            ],

        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
