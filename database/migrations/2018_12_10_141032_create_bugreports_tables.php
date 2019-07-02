<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBugReportsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugReports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reportType')->comment('报告分类');
            $table->text('content')->comment('报告内容');
            $table->string('contact')->nullable()->comment('联系');
            $table->string('screenShot')->nullable()->comment('截图地址');
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
        Schema::dropIfExists('bugReports');
    }
}
