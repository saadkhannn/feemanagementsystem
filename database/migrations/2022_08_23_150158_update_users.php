<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
           $table->dropColumn([
            'name',
            'email'
           ]);
           
           $table->unsignedBigInteger('employee_id')->after('id');
           $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');

           $table->string('username')->after('employee_id');
           
           $table->integer('is_developer')->after('password')->default(0);
           $table->integer('status')->after('is_developer')->default(1);
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
           $table->string('name')->after('id');
           $table->string('email')->after('name')->unique();
            
           $table->dropForeign([
                'employee_id',
           ]);

           $table->dropColumn([
                'employee_id',
                'username',
                'is_developer',
                'status',
           ]);
        });
    }
}
