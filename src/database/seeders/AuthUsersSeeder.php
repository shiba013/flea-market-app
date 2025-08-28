<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'test',
                'email' => 'test@example.com',
                'password' => Hash::make('password1234'),
                'email_verified_at' => now(),
                'post_code' => '111-1111',
                'address' => '東京都',
                'building' => '東京ビル',
            ],
            [
                'name' => 'dummy',
                'email' => 'dummy@example.com',
                'password' => Hash::make('dummy1234'),
                'email_verified_at' => now(),
                'post_code' => '222-2222',
                'address' => '千葉県',
                'building' => '千葉ビル',
            ],
            [
                'name' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('user1234'),
                'email_verified_at' => now(),
                'post_code' => '333-3333',
                'address' => '北海道',
                'building' => '北海道ビル',
            ]
        ]);
    }
}
