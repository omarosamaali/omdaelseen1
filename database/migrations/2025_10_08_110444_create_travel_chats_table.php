<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel_chats', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('trip_id'); // ربط الرسالة بطلب الرحلة
            $table->unsignedBigInteger('user_id'); // المستخدم اللي أرسل الرسالة
            $table->text('message')->nullable(); // الرسالة النصية
            $table->string('image')->nullable(); // الصورة (اختياري)
            $table->timestamps();

            // العلاقات (foreign keys)
            $table->foreign('trip_id')->references('id')->on('trip_requests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_chats');
    }
};
