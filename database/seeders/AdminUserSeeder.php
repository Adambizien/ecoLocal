<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'test@exemple.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Project Leader',
            'email' => 'leader@exemple.com',
            'password' => Hash::make('user123'),
            'role' => 'project_leader',
        ]);
    }
}
//php artisan db:seed --class=AdminUserSeeder