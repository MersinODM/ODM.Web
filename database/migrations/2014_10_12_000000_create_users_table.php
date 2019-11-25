<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   * @return void
   */
  public function up()
  {
    Schema::create("units", function (Blueprint $table) {
      $table->increments("id");
      $table->string("name", 200);
      $table->string("code", 10);
    });

    Schema::create("institutions", function (Blueprint $table) {
      $table->unsignedInteger("id")->primary();
      $table->unsignedInteger("unit_id");
      $table->string("name");
      $table->string("phone")->nullable();

      $table->foreign('unit_id')
        ->references('id')->on('units');
    });

    //Dersler/Alanlar tablosu
    Schema::create("branches", function (Blueprint $table) {
      $table->increments('id');
      $table->string("name", 50);
      $table->string("code", 10)->nullable();
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger("branch_id")->nullable(); //Alan id
      $table->unsignedInteger("inst_id")->nullable(); //Kurum id
      $table->unsignedInteger("activator_id")->nullable(); //Kurum id
      $table->string('full_name');
      $table->string('phone');
      $table->string('email')->unique();
      $table->string('password')->nullable();
      $table->date('activation_date')->nullable();
      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('branch_id')
        ->references('id')->on('branches');

      $table->foreign('inst_id')
        ->references('id')->on('institutions');

      $table->foreign('activator_id')
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
    Schema::drop('users');
    Schema::drop('branches');
    Schema::drop('institutions');
    Schema::drop('units');

  }
}
