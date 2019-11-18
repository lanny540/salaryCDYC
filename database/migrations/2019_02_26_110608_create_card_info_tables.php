<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardInfoTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('card_info', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->comment('用户ID，外键');
            $table->string('remit_card_no')->comment('代汇卡号');
            $table->string('remit_name')->comment('代汇姓名');
            $table->string('remit_bank')->comment('代汇开户行');
            $table->string('remit_address_no')->comment('代汇地区码');
            $table->string('remit_province')->comment('代汇省份');
            $table->string('remit_city')->comment('代汇市');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('card_info', function (Blueprint $table) {
            $table->dropForeign('card_info_user_id_foreign');
        });
        Schema::dropIfExists('card_info');
    }
}
