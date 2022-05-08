<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            array(
                'name' => 'admin',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'patient',
                'guard_name' => 'web'
            ),
        );

        DB::table('roles')->insert($roles);
    }
}
