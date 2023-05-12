<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaxRules extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tax_rules');
        
        Schema::create('tax_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tax_id')->unsigned();
            $table->double('amount_from')->default(0);
            $table->double('amount_to')->default(0);
            $table->double('tax_percentage')->default(0);
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
        Schema::dropIfExists('tax_rules');
    }
}
