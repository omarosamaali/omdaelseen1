<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question_ar')->nullable();
            $table->text('question_en')->nullable();
            $table->text('question_zh')->nullable();
            $table->text('answer_ar')->nullable();
            $table->text('answer_en')->nullable();
            $table->text('answer_zh')->nullable();
            $table->enum('status', ['نشط', 'غير نشط'])->default('نشط');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}