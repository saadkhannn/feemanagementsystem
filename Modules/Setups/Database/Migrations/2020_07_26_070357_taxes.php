<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Taxes extends Migration
{
    public function up()
    {
        Schema::dropIfExists('taxes');
        
        Schema::create('taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->double('starter')->default(0);
            $table->double('starter_for_male')->default(0);
            $table->double('starter_for_female')->default(0);
            $table->text('desc')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}
