<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Silber\Bouncer\Database\Models;

class CreateQuestionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    //Kazanımlar tablosu
    Schema::create("learning_outcomes", function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger("branch_id")->nullable(false);
      $table->string("code", 50)->nullable(false);
      $table->string("content", 4000)->nullable(false);
      $table->string("description", 6000)->nullable(true);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('branch_id')
        ->references('id')->on('branches');
    });

    Schema::create("blooms_taxonomy", function (Blueprint $table) {
      $table->increments('id');
      $table->string("code", 50)->nullable(true);
      $table->string("content", 200)->nullable(false);
      $table->string("description", 6000)->nullable(true);
      $table->timestamps();
      $table->softDeletes();
    });

    //Sorular tablosu
    Schema::create('questions', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger("creator_id"); //Soru yazarı id
      $table->unsignedInteger("lesson_id"); //Ders branş id
      $table->unsignedInteger("learning_outcome_id"); //Kazanım id
      $table->unsignedInteger("taxonomy_id")->nullable(); //Kazanım id
      $table->unsignedInteger("difficulty_point")->nullable(); // 1 - 5 arası
      $table->string("item_root", 5000);
      $table->string("content_url", 2000)->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('creator_id')
        ->references('id')->on('users');

      $table->foreign('lesson_id')
        ->references('id')->on('branches');

      $table->foreign('learning_outcome_id')
        ->references('id')->on('learning_outcomes');

      $table->foreign('taxonomy_id')
        ->references('id')->on('blooms_taxonomy');
    });

    //Cevap şıkları tablosu
    Schema::create('answer_choices', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger("question_id")->nullable(false);
      $table->string("content", 3000)->nullable(true); //Seçenek içeriği
      $table->string("content_url", 2000)->nullable();
      $table->boolean("is_correct");
      $table->timestamps();
//            $table->softDeletes();

      $table->foreign('question_id')
        ->references('id')->on('questions');
    });


    //Soru değerlendirme tablosu
    Schema::create('questions_evaluation', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger("question_id"); //Soru
      $table->unsignedInteger("elector_id"); //Puanlayıcı
      $table->integer("point"); //Puan 1-5 arası
      $table->string("comment", 2000)->nullable();
      $table->timestamps();

      $table->foreign('question_id')
        ->references('id')->on('questions');

      $table->foreign('elector_id')
        ->references('id')->on('users');
    });

    //Soru düzeltme öneri tablosu
    Schema::create('question_comments', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger("question_id"); //Soru
      $table->unsignedInteger("commenter_id"); //Öneri yapan
      $table->string("content", 3000)->nullable(false);
      $table->timestamps();

      $table->foreign('question_id')
        ->references('id')->on('questions');

      $table->foreign('commenter_id')
        ->references('id')->on('users');
    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('question_comments');
    Schema::drop('questions_evaluation');
    Schema::drop('answer_choices');
//        Schema::drop('questions_statistic');
    Schema::drop('questions');
    Schema::drop('learning_outcomes');

  }
}
