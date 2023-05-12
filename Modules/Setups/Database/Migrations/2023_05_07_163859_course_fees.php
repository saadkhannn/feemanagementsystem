<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourseFees extends Migration
{
    public function up()
    {
        Schema::dropIfExists('course_fees');
        
        Schema::create('course_fees', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('course_id', false);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');

            $table->date('date');
            $table->double('fee')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_fees');
    }
}
