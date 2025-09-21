<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique(); // رقم المستند
            $table->morphs('order'); // Adds order_id (unsignedBigInteger) and order_type (string)
            $table->date('document_date'); // تاريخ المستند
            $table->string('title'); // العنوان
            $table->text('details'); // التفاصيل
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->after('file_path');
            $table->string('file_path')->nullable(); // مسار الملف (اختياري)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
