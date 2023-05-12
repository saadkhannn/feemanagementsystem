<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LegalEntitiess extends Migration
{
    public function up()
    {
        Schema::dropIfExists('legal_entities');
        
        Schema::create('legal_entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('brand_id')->unsigned();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('contact_info')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('legal_entities');
    }
}
