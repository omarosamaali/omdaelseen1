<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpWordsTable extends Migration
{
    public function up()
    {
        Schema::create('help_words', function (Blueprint $table) {
            $table->id();
            $table->string('word_ar')->nullable();
            $table->string('word_en')->nullable();
            $table->string('word_zh')->nullable();
            $table->enum('status', ['نشط', 'غير نشط'])->default('نشط');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('help_words');
    }
}