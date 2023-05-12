<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BillCollections extends Migration
{
    public function up()
    {
        Schema::dropIfExists('user_bill_collections');
        
        Schema::create('user_bill_collections', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_bill_id', false);
            $table->foreign('user_bill_id')->references('id')->on('user_bills')->onDelete('cascade')->onUpdate('cascade');

            $table->date('date');
            $table->double('collection')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_bill_collections');
    }
}
