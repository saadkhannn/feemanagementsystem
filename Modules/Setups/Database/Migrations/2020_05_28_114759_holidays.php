<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Holidays extends Migration
{
    public function up()
    {
        Schema::dropIfExists('holidays');
        
        Schema::create('holidays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('holiday_type_id')->unsigned();
            $table->string('name');
            $table->date('date');
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
        Schema::dropIfExists('holidays');
    }
}
