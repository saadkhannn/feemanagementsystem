<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserBills extends Migration
{
    public function up()
    {
        Schema::dropIfExists('user_bills');
        
        Schema::create('user_bills', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_course_id', false);
            $table->foreign('user_course_id')->references('id')->on('user_courses')->onDelete('cascade')->onUpdate('cascade');

            $table->date('deadline');
            $table->double('fee')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_bills');
    }
}
