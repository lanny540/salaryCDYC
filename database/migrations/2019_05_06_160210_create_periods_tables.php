<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('published_at', 16)->comment('发放日期');
            $table->dateTime('startdate')->nullable()->comment('周期开始时间');
            $table->dateTime('enddate')->nullable()->comment('周期结束时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('periods');
    }
}
