<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeparationOptions extends Migration
{
    public function up()
    {
        Schema::dropIfExists('separation_options');
        
        Schema::create('separation_options', function (Blueprint $table) {
            $table->bigIncrements('id');
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
        Schema::dropIfExists('separation_options');
    }
}
