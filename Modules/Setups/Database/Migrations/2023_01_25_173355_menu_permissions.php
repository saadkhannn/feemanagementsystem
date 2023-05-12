<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MenuPermissions extends Migration
{
    public function up()
    {
        Schema::dropIfExists('menu_permissions');
        
        Schema::create('menu_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('menu_id')->unsigned();
            $table->foreign('menu_id')->references('id')->on('menu')->onDelete('cascade')->onUpdate('cascade');
            
            $table->bigInteger('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('menu_permissions');
    }
}
