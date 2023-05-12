<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserCourses extends Migration
{
    public function up()
    {
        Schema::dropIfExists('user_courses');
        
        Schema::create('user_courses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id', false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('course_id', false);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_courses');
    }
}
