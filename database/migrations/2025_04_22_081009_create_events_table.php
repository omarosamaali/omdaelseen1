<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->string('title_zh')->nullable();
            $table->text('description_ar');
            $table->text('description_en')->nullable();
            $table->text('description_zh')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['معرض', 'مناسبة']);
            $table->enum('status', ['نشط', 'غير نشط']);
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}