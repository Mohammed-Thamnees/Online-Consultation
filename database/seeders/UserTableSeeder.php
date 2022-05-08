<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array(
                'first_name' => 'admin',
                'email' => 'admin@gmail.com',
                'gender' => 'male',
                'phone' => 9074787667,
                'password' => Hash::make('password'),
            )
        );

        DB::table('users')->insert($users);
    }
}
