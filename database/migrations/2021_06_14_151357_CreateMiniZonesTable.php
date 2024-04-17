<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country',200)->default(null)->nullable();
            $table->string('city',200)->default(null)->nullable();
            $table->string('state',200)->default(null)->nullable();
            $table->string('zone_name',200)->default(null)->nullable();
            $table->string('currency',200)->default(null)->nullable();
            $table->string('status',200)->default(null)->nullable();
            $table->string('background',200)->default(null)->nullable();
            $table->string('draw_lines',200)->default(null)->nullable();
            $table->binary('coordinate')->default(null)->nullable();

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
        Schema::dropIfExists('request_payment_items');
    }
}
