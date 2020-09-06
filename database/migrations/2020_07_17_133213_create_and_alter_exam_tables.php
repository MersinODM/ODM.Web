<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAndAlterExamTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('exams', function (Blueprint $table) {
//            $table->integer('');
//        });




        Schema::table('exams', function (Blueprint $table) {
            $table->integer('purpose_id')->after("status_id");
            $table->string('code',50)->after("purpose_id");
            $table->dateTime('date_of_occurrence')->nullable();
            $table->renameColumn('status_id', 'status');
        });


        Schema::create('exam_purposes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('purpose', 500);
            $table->string('code', 20)->nullable();
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
        Schema::dropIfExists('exam_purposes');
    }
}
