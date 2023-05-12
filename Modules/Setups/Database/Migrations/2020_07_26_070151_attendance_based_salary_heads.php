<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttendanceBasedSalaryHeads extends Migration
{
    public function up()
    {
        Schema::dropIfExists('attendance_based_salary_heads');
        
        Schema::create('attendance_based_salary_heads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->integer('type')->default(1);
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
        Schema::dropIfExists('attendance_based_salary_heads');
    }
}
