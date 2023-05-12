<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttendanceBaesdSalaryHeadDetails extends Migration
{
    public function up()
    {
        Schema::dropIfExists('attendance_based_salary_head_details');
        
        Schema::create('attendance_based_salary_head_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('salary_head_id')->unsigned();
            $table->date('date');
            $table->double('unit_for_absent')->default(0);
            $table->double('percentage_from')->default(1)->comment('1 for gross, 0 for basic');
            $table->double('percentage')->default(0);
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
        Schema::dropIfExists('attendance_based_salary_head_details');
    }
}
