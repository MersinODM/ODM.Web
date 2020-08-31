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

        // alter table exams change status_id status int unsigned not null;

//        alter table exams
//    add date_of_occurrence datetime null after planned_date;
//
//alter table exams
//    add purpose_id int null after creator_id;

//        alter table exams
//	add path varchar(255) null after date_of_occurrence;


//        alter table exams
//	add code varchar(50) null after purpose_id;


//        create table exam_purposes
//    (
//        id int not null,
//	purpose varchar(500) not null,
//	code varchar(50) null,
//	created_at timestamp null,
//	updated_at timestamp null,
//	constraint exam_purposes_pk
//		primary key (id)
//);

//        alter table branches
//	add class_levels varchar(200) null after code;


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
