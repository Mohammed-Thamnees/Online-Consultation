<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignRoleTableSeeder extends Seeder
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
                'role_id' => '1',
                'model_type' => 'App\Models\User',
                'model_id' => '1'
            )
        );

        DB::table('model_has_roles')->insert($roles);
    }
}
