<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalaryHeadDetails extends Migration
{
    public function up()
    {
        Schema::dropIfExists('salary_head_details');
        
        Schema::create('salary_head_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('salary_head_id')->unsigned();
            $table->date('date');
            $table->double('percentage')->default(0);
            $table->integer('taxable')->default(0);
            $table->double('yearly_tax_examption')->default(0);
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
        Schema::dropIfExists('salary_head_details');
    }
}
