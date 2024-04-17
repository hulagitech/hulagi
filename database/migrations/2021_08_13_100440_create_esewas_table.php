<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsewasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esewas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('User_ID');
            $table->string('User_Name');
            $table->float('Amount');
            $table->string('Payment_ID');
            $table->string('Reference_ID');
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
        Schema::dropIfExists('esewas');
    }
}
