<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
     Schema::create('userinfos', function (Blueprint $table) {
            $table->increments('id',11);
            $table->string('username', 128)->nullable(false);
            $table->string('password', 128);
            $table->string('type', 128)->nullable(false);
            $table->string('status', 128)->nullable(false);
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('userinfos');
    }
}
