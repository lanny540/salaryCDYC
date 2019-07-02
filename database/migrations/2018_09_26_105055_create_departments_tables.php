<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->comment('部门名称');
            $table->string('dwdm', 32)->comment('部门编码');
            $table->smallInteger('pid')->default(0)->comment('父节点ID');
            $table->smallInteger('weight')->default(1)->comment('排序');
            $table->tinyInteger('level')->default(1)->comment('层级');
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
        Schema::dropIfExists('departments');
    }
}
