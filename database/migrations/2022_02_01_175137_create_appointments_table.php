<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('doctor_id');
            $table->integer('token_no');
            $table->date('date');
            $table->string('method')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->string('status')->default('new');
            $table->float('weight')->nullable();
            $table->float('blood_pressure')->nullable();
            $table->float('pulse')->nullable();
            $table->float('temperature')->nullable();
            $table->text('problem')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
