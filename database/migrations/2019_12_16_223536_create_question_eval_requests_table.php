<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionEvalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_eval_requests', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('elector_id')->nullable(false);
            $table->unsignedInteger('creator_id')->nullable(false);
            $table->unsignedInteger('question_id')->nullable(false);
            $table->string('code', 50)->nullable(true);
            $table->string('comment', 1000)->nullable(true);
            $table->unsignedInteger('point')->nullable(true);
            $table->boolean('is_open')->default(true);
            $table->timestamps();

            $table->foreign('elector_id')
                ->references('id')->on('users');

            $table->foreign('creator_id')
                ->references('id')->on('users');

            $table->foreign('question_id')
                ->references('id')->on('questions');
        });

        Schema::create('question_revision_requests', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('creator_id')->nullable(false);
            $table->unsignedInteger('question_id')->nullable(false);
            $table->string('title', 1000)->nullable(true);
            $table->string('comment', 1000)->nullable(true);
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_eval_requests');
        Schema::dropIfExists('question_revision_requests');
    }
}
