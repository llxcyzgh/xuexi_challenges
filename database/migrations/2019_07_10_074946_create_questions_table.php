<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('question_md5', 32)->unique();
            $table->text('question'); // 问题
            $table->string('options')->nullable(); // 选项
            $table->string('answer')->nullable(); // 正确答案
            $table->string('provenance')->nullable(); // 出处
            $table->tinyInteger('is_verified'); // 是否验证答案

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
        Schema::dropIfExists('questions');
    }
}
