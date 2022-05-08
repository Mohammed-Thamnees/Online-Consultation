<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = array(
            array(
                'name' => 'role_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'role_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'role_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'role_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'permission_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'permission_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'permission_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'permission_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'permission_assign',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'user_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'user_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'user_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'user_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'category_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'category_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'category_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'category_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_show',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'banner_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'banner_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'banner_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'banner_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_availability_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_availability_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_availability_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'doctor_availability_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'story_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'story_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'story_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'story_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'web_settings',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'coupon_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'coupon_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'coupon_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'coupon_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'chat_settings',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'chat',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_type_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_type_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_type_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_type_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_define_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_define_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_define_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_define_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_approve',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'leave_pending',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'medicine_type_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'medicine_type_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'medicine_type_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'medicine_type_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'medicine_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'medicine_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'medicine_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'medicine_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'appointment_today',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'appointment_new',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'appointment_history',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'appointment_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'appointment_edit',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'appointment_view',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'appointment_delete',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'ticket_list',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'ticket_create',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'ticket_update',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'ticket_show',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'ticket_reply',
                'guard_name' => 'web'
            ),
            array(
                'name' => 'ticket_delete',
                'guard_name' => 'web'
            ),
        );

        DB::table('permissions')->insert($permissions);
    }
}
