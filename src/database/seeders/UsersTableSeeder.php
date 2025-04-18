<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'テストユーザー1',
            'email' => 'test1@example.com',
            'password' => Hash::make('test_user1'),
            'image' => 'profile_icon.jpg',
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'テストユーザー2',
            'email' => 'test2@example.com',
            'password' => Hash::make('test_user2'),
            'image' => 'profile_icon.jpg',
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'テストユーザー3',
            'email' => 'test3@example.com',
            'password' => Hash::make('test_user3'),
            'image' => 'profile_icon.jpg',
        ];
        DB::table('users')->insert($param);
    }
}
