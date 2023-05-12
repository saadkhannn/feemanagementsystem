<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProvidentFundSettings extends Migration
{
    public function up()
    {
        Schema::dropIfExists('provident_fund_settings');
        
        Schema::create('provident_fund_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->double('company_percentage');
            $table->double('employee_percentage');
            $table->bigInteger('employee_id')->unsigned();
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
        Schema::dropIfExists('provident_fund_settings');
    }
}
