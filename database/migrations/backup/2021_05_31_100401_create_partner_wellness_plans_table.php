<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerWellnessPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_wellness_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('partner_id');
            $table->string('plan_code');
            $table->string('plan_name');
            $table->string('external_reference')->nullable();
            $table->string('description')->nullable();
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->unique(['partner_id', 'plan_code'], "unique_wellness_plan_code");
            $table->unique(['partner_id', 'plan_name'], "unique_wellness_plan_name");
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
        Schema::dropIfExists('partner_wellness_plans');
    }
}
