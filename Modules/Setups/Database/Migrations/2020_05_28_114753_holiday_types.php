<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HolidayTypes extends Migration
{
    public function up()
    {
        Schema::dropIfExists('holiday_types');
        
        Schema::create('holiday_types', function (Blueprint $table) {
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
        Schema::dropIfExists('holiday_types');
    }
}
