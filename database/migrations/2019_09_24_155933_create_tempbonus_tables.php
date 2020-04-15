<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempbonusTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tempbonus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dwdm', 32)->comment('部门编码');
            $table->string('policyNumber', 24)->index()->comment('保险编号');
            $table->decimal('month_bonus', 14, 2)->default(0)->comment('月奖');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tempbonus');
    }
}
