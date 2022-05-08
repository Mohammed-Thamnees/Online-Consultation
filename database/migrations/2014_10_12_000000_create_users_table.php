<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('pin')->nullable();
            $table->string('place')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('gender');
            $table->string('image')->nullable();
            $table->string('status')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active_status')->default(0);
            $table->string('avatar')->default(config('chatify.user_avatar.default'));
            $table->boolean('dark_mode')->default(0);
            $table->string('messenger_color')->default('#2180f3');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
