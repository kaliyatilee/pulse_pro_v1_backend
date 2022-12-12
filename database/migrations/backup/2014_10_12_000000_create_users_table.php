<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname')->default('');
            $table->string('lastname')->default('');
            $table->string('bmi')->default('');
            $table->string('dob')->default('');
            $table->string('gender')->default('');
            $table->string('height')->default('');
            $table->string('weight')->default('');
            $table->string('loyaltpoints')->default(0);
            $table->string('partnerId')->default(1);
            $table->string('phone')->default('');
            $table->string('email')->unique();
            $table->string('status')->default('active');
            $table->string('macAddress')->default('');
            $table->string('fcm_tokken')->default('');
            $table->string('is_admin')->default(0);
            $table->string('roleId')->default(2);
            $table->boolean('is_verified')->default(false);
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
