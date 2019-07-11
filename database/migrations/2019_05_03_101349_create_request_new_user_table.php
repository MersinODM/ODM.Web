<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateRequestNewUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("new_user_reqs", function (Blueprint $table) {
          $table->increments("id");
          $table->unsignedInteger("confirmatory_id"); //Kim omnayladı
          $table->string("full_name");
          $table->string("title")->nullable();
          $table->string("phone");
          $table->string("email");
          $table->unsignedInteger("inst_id");
          $table->unsignedInteger("branch_id");
          $table->boolean("is_confirmed")->default(false);  //Onaylandı mı?
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("new_user_reqs");
    }
}
