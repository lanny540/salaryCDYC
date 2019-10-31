<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportconfigTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importconfig', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id')->comment('角色ID');
            $table->string('db_column')->comment('数据表中的字段');
            $table->string('human_column')->comment('显示的字段');
            $table->string('excel_column')->comment('excel读取的字段');
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
        Schema::dropIfExists('importconfig');
    }
}
