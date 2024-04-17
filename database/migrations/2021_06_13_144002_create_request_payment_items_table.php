<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPaymentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_payment_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_request_id')->nullable();
            $table->foreign('payment_request_id')->references('id')->on('payment_requests');
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('user_requests');

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
