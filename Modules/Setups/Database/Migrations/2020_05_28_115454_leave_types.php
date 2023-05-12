<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaveTypes extends Migration
{
    public function up()
    {
        Schema::dropIfExists('leave_types');
        
        Schema::create('leave_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('balance');
            $table->integer('hour_leave')->default(0);
            $table->integer('half_day')->default(0);
            $table->integer('documents')->default(0);
            $table->integer('gender_oriented')->default(0);
            $table->integer('gender')->nullable();
            $table->text('desc')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('leave_types');
    }
}
