<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Subfunctions extends Migration
{
    public function up()
    {
        Schema::dropIfExists('sub_functions');
        
        Schema::create('sub_functions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('function_id')->unsigned();
            $table->string('name');
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
        Schema::dropIfExists('sub_functions');
    }
}
