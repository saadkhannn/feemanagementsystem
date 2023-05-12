<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Joblocations extends Migration
{
    public function up()
    {
        Schema::dropIfExists('job_locations');
        
        Schema::create('job_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('job_locations');
    }
}
