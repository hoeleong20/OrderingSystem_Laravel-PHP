<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'usertype' => 'admin',
                'account_number' => '1234567890',
            ],[
                'id' => 2,
                'name' => 'Test admin',
                'email' => '1@1',
                'email_verified_at' => now(),
                'password' => Hash::make('1'),
                'usertype' => 'admin',
                'account_number' => '1234567890',
            ],[
                'id' => 3,
                'name' => 'Test customer',
                'email' => '2@2',
                'email_verified_at' => now(),
                'password' => Hash::make('2'),
                'usertype' => 'user',
                'account_number' => '1234567890',
            ]
        ]);
    }
}
