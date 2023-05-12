<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrusteeBoards extends Migration
{
    public function up()
    {
        Schema::dropIfExists('trustee_boards');
        
        Schema::create('trustee_boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('legal_entity_id')->unsigned();
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
        Schema::dropIfExists('trustee_boards');
    }
}
