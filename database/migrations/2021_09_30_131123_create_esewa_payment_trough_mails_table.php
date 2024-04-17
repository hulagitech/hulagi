<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsewaPaymentTroughMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esewa_payment_trough_mails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->integer('user_id');
            $table->string('Name');
            $table->float('Amount');
            $table->string('EsewaToken');
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
        Schema::dropIfExists('esewa_payment_trough_mails');
    }
}
