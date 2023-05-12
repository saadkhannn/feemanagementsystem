<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Shifts extends Migration
{
    public function up()
    {
        Schema::dropIfExists('shifts');
        
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type')->default(1);
            $table->string('name');
            $table->time('from');
            $table->time('to');
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
        Schema::dropIfExists('shifts');
    }
}
