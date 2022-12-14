<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfileUsers;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create admin
        User::create([
            'name' => 'Iam Admin',
            'password' => Hash::make('12345678'),
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'role' => 'Administrator',
            'created_at' => now()
        ]);
        ProfileUsers::create([
            'user_id' => 1,
            'nama' => 'Iam Admin',
            'email' => 'admin@gmail.com',
            'created_at' => now()
        ]);

        User::create([
            'name' => 'Iam User',
            'password' => Hash::make('12345678'),
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'role' => 'Calon Mahasiswa',
            'created_at' => now()
        ]);

        ProfileUsers::create([
            'user_id' => 2,
            'nama' => 'Iam User',
            'email' => 'user@gmail.com',
            'created_at' => now()
        ]);

    }
}
