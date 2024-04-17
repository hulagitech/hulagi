<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebsiteFacebook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('next_user_dashboards', function (Blueprint $table) {
            $table->string('website_facebook')->nullable();
            $table->string('website_linkedin')->nullable();
            $table->string('website_instagram')->nullable();
            $table->string('websitelink')->nullable();
            $table->string('subdomain_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('next_user_dashboards', function (Blueprint $table) {
            //
        });
    }
}
