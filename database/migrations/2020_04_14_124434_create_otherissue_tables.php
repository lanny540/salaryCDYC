<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherissueTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otherissue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('period_id')->comment('会计周期');
            $table->decimal('money', 14, 2)->default(0.00)->comment('金额');
            $table->string('remark')->default('其他发放')->comment('备注');
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
        Schema::dropIfExists('otherissue');
    }
}
