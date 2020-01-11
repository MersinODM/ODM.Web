<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('notifications', static function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('creator_id');
            $table->string('title', 300)->nullable();
            $table->string('content', 1000);
            $table->string('url', 500)->nullable();
            $table->integer('severity')->nullable(); // 1 - 3 arası değer
            $table->timestamps();

            $table->foreign('creator_id')
                ->references('id')->on('users');
        });

        Schema::create('user_notifications', static function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('notification_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->foreign('notification_id')
                ->references('id')->on('notifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_notifications');
        Schema::dropIfExists('notifications');
    }
}
