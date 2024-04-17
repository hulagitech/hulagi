<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextUserDashboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_user_dashboards', function (Blueprint $table) {
            $table->id();
            $table->string('APP_NAME');
            $table->string('Email');
            $table->string('phone');
            $table->string('location');
            $table->string('App_logo');
            $table->string('App_icon');
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
        Schema::dropIfExists('next_user_dashboards');
    }
}
