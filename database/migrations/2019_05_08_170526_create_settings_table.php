<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('governor'); //Kaymakamlık/Valilik
            $table->string('directorate'); //Müdürlük
            $table->string('twitter_address')->nullable();
            $table->string('facebook_address')->nullable();
            $table->string('instagram_address')->nullable();
            $table->string('web_address')->nullable();
            $table->string("inst_name", 300); //Kurum adı
            $table->string('phone', 15);
            $table->string("email", 50);
            $table->string("address", 500);
            $table->string("logo_url", 300)->nullable();
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
        Schema::drop('settings');
    }
}
