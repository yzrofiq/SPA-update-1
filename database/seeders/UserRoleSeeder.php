<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Default User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // Ganti dengan password yang lebih aman
            'role' => 'user', // Role untuk user
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
