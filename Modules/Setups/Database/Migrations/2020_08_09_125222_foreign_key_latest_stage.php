<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeyLatestStage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_head_details', function($table) {
           $table->foreign('salary_head_id')->references('id')->on('salary_heads')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('attendance_based_salary_head_details', function($table) {
           $table->foreign('salary_head_id')->references('id')->on('attendance_based_salary_heads')->onDelete('restrict')->onUpdate('cascade');
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
