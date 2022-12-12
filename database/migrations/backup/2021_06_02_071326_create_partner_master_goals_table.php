<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerMasterGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_master_goals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->string('goal_name');
            $table->string('goal_type');
            $table->string('required_target');
            $table->string('goal_measurement');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->unique(['partner_id','goal_name'], 'unique_goal_name');
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
        Schema::dropIfExists('partner_master_goals');
    }
}
