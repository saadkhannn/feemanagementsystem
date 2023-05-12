<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalaryHeads extends Migration
{
    public function up()
    {
        Schema::dropIfExists('salary_heads');
        
        Schema::create('salary_heads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->integer('basic')->default(0);
            $table->integer('type')->default(1);
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
        Schema::dropIfExists('salary_heads');
    }
}
