<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoanSettings extends Migration
{
    public function up()
    {
        Schema::dropIfExists('loan_rules');
        
        Schema::create('loan_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('loan_type_id')->unsigned();
            $table->date('date');
            $table->double('min_amount');
            $table->double('max_amount');
            $table->double('min_installments');
            $table->double('max_installments');
            $table->integer('max_loan_per_year')->default(0);
            $table->integer('max_loans')->default(0);
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
        Schema::dropIfExists('loan_rules');
    }
}
