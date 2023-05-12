<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubmenuPermissions extends Migration
{
    public function up()
    {
        Schema::dropIfExists('submenu_permissions');
        
        Schema::create('submenu_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('submenu_id')->unsigned();
            $table->foreign('submenu_id')->references('id')->on('submenu')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('submenu_permissions');
    }
}
