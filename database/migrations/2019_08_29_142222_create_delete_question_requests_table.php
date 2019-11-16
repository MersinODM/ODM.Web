<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleteQuestionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_delete_requests', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger("question_id")->nullable(true);
            $table->unsignedInteger("creator_id");
            $table->unsignedInteger("lo_id");
            $table->string("comment", 500);
            $table->string("keywords", 500);
            $table->boolean("is_accepted")->nullable(true);
            $table->boolean("acceptor_id")->nullable(true);
            $table->timestamps();
//            $table->foreign('creator_id')
//                ->references('id')->on('questions')
//            $table->foreign('acceptor_id')
//                ->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delete_question_requests');
    }
}
