<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Designations extends Migration
{
    public function up()
    {
        Schema::dropIfExists('designations');
        
        Schema::create('designations', function (Blueprint $table) {
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
        Schema::dropIfExists('designations');
    }
}
