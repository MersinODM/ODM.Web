<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("statuses", function (Blueprint $table) {
      $table->increments("id");
      $table->string("title", 50);
      $table->string("code", 10)->nullable();
    });




    Schema::create("exams", function (Blueprint $table) {
      $table->increments("id");
      $table->unsignedInteger("creator_id");
      $table->unsignedInteger("status_id");
      $table->string("title");
      $table->integer("class_level");
      $table->dateTime("planned_date");
      $table->string("description", 5000)->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('creator_id')
        ->references('id')->on('users');

      $table->foreign('status_id')
        ->references('id')->on('statuses');


    });

    Schema::create("exam_groups", function (Blueprint $table) {
      $table->increments("id");
      $table->unsignedInteger("exam_id");
      $table->string("name", 150);
      $table->string("code", 10)->nullable();

      $table->foreign('exam_id')
        ->references('id')->on('exams');
    });

    Schema::create("answer_keys", function (Blueprint $table) {
      $table->increments("id");
      $table->unsignedInteger("exam_group_id");
      $table->unsignedInteger("answer_choice_id");
      $table->string("key", 5);

      $table->foreign('exam_group_id')
        ->references('id')->on('exam_groups');

      $table->foreign('answer_choice_id')
        ->references('id')->on('answer_choices');
    });

    Schema::create("exam_lessons", function (Blueprint $table) {
      $table->increments("id");
      $table->unsignedInteger("exam_id");
      $table->unsignedInteger("lesson_id");
      $table->timestamps();

      $table->foreign('exam_id')
        ->references('id')->on('exams');

      $table->foreign('lesson_id')
        ->references('id')->on('branches');

    });

    Schema::create("exam_questions", function (Blueprint $table) {
      $table->increments("id");
      $table->unsignedInteger("exam_id")->nullable(false);
      $table->unsignedInteger("question_id")->nullable(false);
      $table->timestamps();

      $table->foreign('exam_id')
        ->references('id')->on('exams');

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
    Schema::drop('answer_keys');
    Schema::drop('exam_questions');
    Schema::drop('exam_lessons');
    Schema::drop('exam_groups');
    Schema::drop('exams');
    Schema::drop('statuses');
  }
}
