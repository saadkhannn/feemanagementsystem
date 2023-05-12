<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentToUsers extends Migration
{
    public function up()
    {
        Schema::dropIfExists('user_departments');
        
        Schema::create('user_departments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id', false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('department_id', false);
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_departments');
    }
}
