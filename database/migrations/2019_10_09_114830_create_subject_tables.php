<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject_no', 64)->comment('科目编码');
            $table->string('subject_name')->comment('科目名称');
            $table->tinyInteger('subject_type')->comment('科目类别.ERP编码分为6段，即0-5');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject');
    }
}
