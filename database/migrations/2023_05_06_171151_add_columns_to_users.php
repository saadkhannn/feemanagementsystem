<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
           // $table->dropForeign([
           //      'employee_id',
           // ]);

           // $table->dropColumn([
           //      'employee_id',
           // ]);

           $table->string('first_name')->after('id');
           $table->string('last_name')->after('first_name')->nullable();
           $table->string('email')->after('last_name')->nullable();
           $table->integer('gender')->after('password')->default(1);
           $table->text('image')->after('gender')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
           // $table->unsignedBigInteger('employee_id')->after('id');
           // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');

           $table->dropColumn([
                'first_name',
                'last_name',
                'email',
                'gender',
                'image',
           ]);
        });
    }
}
