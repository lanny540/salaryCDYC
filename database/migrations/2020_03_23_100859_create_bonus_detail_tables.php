<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusDetailTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_type', function (Blueprint $table) {
            $table->integer('id')->unique()->nullable()->comment('对应角色ID');
            $table->string('type');
        });

        Schema::create('bonus_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('wf_id')->default(1)->index()->comment('流程ID');
            $table->integer('type_id')->default(1)->index()->comment('类型ID');
            $table->string('policynumber', 24)->index()->comment('保险编号');
            $table->integer('period_id')->default(1)->index()->comment('会计期ID');
            $table->decimal('money')->default(0.00)->comment('金额');
            $table->string('remarks')->default('')->comment('备注');
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
        Schema::dropIfExists('bonus_type');
        Schema::dropIfExists('bonus_detail');
    }
}
