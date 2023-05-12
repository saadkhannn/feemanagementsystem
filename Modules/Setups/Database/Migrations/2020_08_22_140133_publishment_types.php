<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PublishmentTypes extends Migration
{
    public function up()
    {
        Schema::dropIfExists('publishment_types');
        
        Schema::create('publishment_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
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
        Schema::dropIfExists('publishment_types');
    }
}
