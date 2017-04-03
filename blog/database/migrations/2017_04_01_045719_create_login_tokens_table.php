<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('login_tokens', function (Blueprint $table) {
            $table->increments('id',11);
            $table->string('userid', 128)->nullable(false);
            $table->string('token', 255)->nullable(false);
            $table->string('creation_timestamp', 255)->nullable(false);
            $table->string('creation_date_time', 128)->nullable(false);
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('login_tokens');
    }
}
