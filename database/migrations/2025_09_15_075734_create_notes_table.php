<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('note_number')->unique(); // رقم الملاحظة
            $table->morphs('order'); // Adds order_id (unsignedBigInteger) and order_type (string) for polymorphic relationship
            $table->date('note_date'); // تاريخ الملاحظة
            $table->string('title'); // العنوان
            $table->text('details'); // التفاصيل
            $table->string('file_path')->nullable(); // مسار الملف (اختياري)
            $table->string('status'); // الحالة (عامة، خاصة، ملغية)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
