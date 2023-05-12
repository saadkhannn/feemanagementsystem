<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemInformation extends Migration
{
    public function up()
    {
        Schema::dropIfExists('system_information');
        
        Schema::create('system_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('description');
            $table->text('motto');
            $table->text('tagline');
            $table->text('phone');
            $table->text('mobile');
            $table->text('address');
            $table->text('email');
            $table->text('website');
            $table->text('twitter');
            $table->text('facebook');
            $table->text('instagram');
            $table->text('skype');
            $table->text('linked_in');
            $table->text('logo');
            $table->text('secondary_logo');
            $table->text('icon');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_information');
    }
}
