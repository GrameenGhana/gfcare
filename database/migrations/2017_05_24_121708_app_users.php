<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //


        // Create Teams Table...
        Schema::create('app_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('DOB');
            $table->string('gender');
            $table->string('app_data');
            $table->string('user_gen_id')->nullable();
            $table->string('client_type')->nullable();
            $table->string('afya_phonenumber')->nullable();
            $table->string('afya_sms')->nullable();
            $table->string('start_week')->nullable();
            $table->string('program')->nullable();
            $table->string('facility_id')->nullable();
            $table->string('insured')->nullable();
            $table->string('nationalid_type')->nullable();
            $table->string('national_id')->nullable();
            $table->string('language')->nullable();
            $table->string('location')->nullable();
            $table->string('education')->nullable();
            $table->string('relative_phonenumber')->nullable();
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
        //
          Schema::drop('app_users');
    }
}
