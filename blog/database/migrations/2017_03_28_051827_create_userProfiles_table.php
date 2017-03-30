<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('userprofiles', function (Blueprint $table) {
            $table->increments('id',11);
            $table->rememberToken();
            $table->timestamps();
            $table->integer('user_id', false, 11)->nullable(false);
            $table->date('dateofjoining')->nullable(false);
            $table->date('dob')->nullable(false);
            $table->string('name', 128)->nullable(false);
            $table->string('jobtitle', 128)->nullable(false);
            $table->string('gender', 128);
            $table->string('marital_status', 128);
            $table->string('address1', 128);
            $table->string('address2', 128);
            $table->string('city', 128);
            $table->string('state', 128);
            $table->integer('zip_postal' , false,11);
            $table->string('country', 128);
            $table->string('home_ph', 20);
            $table->string('mobile_ph', 20);
            $table->string('work_email', 128);
            $table->string('other_email', 128);
            $table->string('image', 255);
            $table->bigInteger('bank_account_num',false, 16)->nullable(false);
            $table->string('special_instructions', 500)->nullable(false);
            $table->string('permanent_address', 128)->nullable(false);
            $table->string('current_address', 128)->nullable(false);
            $table->string('pan_card_num', 10)->nullable(false);
            $table->string('emergency_ph1', 20)->nullable(false);
            $table->string('emergency_ph2', 20)->nullable(false);
            $table->string('blood_group', 20)->nullable(false);
            $table->string('medical_condition', 255)->nullable(false);
            $table->string('updated_on', 20)->nullable(false);
            $table->string('slack_id', 255)->nullable(false);
            $table->string('policy_document', 1000)->nullable(false);
            $table->string('team', 500)->nullable(false);
            $table->date('training_completion_date')->nullable(false);
            $table->date('termination_date')->nullable(false);
            $table->string('holding_comments', 128)->nullable(false);
            $table->integer('training_month', false,11)->nullable(false);
            $table->integer('slack_msg', false, 11)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userprofiles');
    }
}
