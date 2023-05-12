<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeeForeignkeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_functions', function($table) {
           $table->foreign('function_id')->references('id')->on('functions')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('teams', function($table) {
           $table->foreign('sub_function_id')->references('id')->on('sub_functions')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('legal_entities', function($table) {
           $table->foreign('brand_id')->references('id')->on('brands')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('trustee_boards', function($table) {
           $table->foreign('legal_entity_id')->references('id')->on('legal_entities')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('trustee_board_members', function($table) {
           $table->foreign('trustee_board_id')->references('id')->on('trustee_boards')->onDelete('restrict')->onUpdate('cascade');
           $table->foreign('employee_id')->references('id')->on('employees')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
