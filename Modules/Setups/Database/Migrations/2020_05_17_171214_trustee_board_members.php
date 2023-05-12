<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrusteeBoardMembers extends Migration
{
    public function up()
    {
        Schema::dropIfExists('trustee_board_members');
        
        Schema::create('trustee_board_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trustee_board_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();
            $table->text('position')->nullable();
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
        Schema::dropIfExists('trustee_board_members');
    }
}
