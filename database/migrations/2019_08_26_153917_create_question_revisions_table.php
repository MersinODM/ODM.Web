<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("question_id");
//            $table->unsignedInteger("creator_id")->nullable(); // Zaten herkes kendi sorusuna revisyon yapacak
            $table->string("title", 250);
            $table->string("comment", 1000);
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')->on('questions');
//            $table->foreign('creator_id')
//                ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_revisions');
    }
}
