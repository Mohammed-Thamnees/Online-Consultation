<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavedefinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leavedefines', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('Leavetype');
            $table->string('Fromdate');
            $table->string('Todate');
            $table->string('Reason');
            $table->string('status')->default(0);
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
        Schema::dropIfExists('leavedefines');
    }
}
