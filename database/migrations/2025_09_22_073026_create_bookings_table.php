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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // رقم المرجع
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('booking_date'); // التاريخ والوقت
            $table->string('order_type'); // نوع الطلب
            $table->string('destination'); // العنوان
            $table->string('customer_name'); // العميل
            $table->string('status'); // الحالة
            $table->decimal('amount', 10, 2); // المبلغ
            $table->string('payment_intent_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->json('payment_data')->nullable();
            $table->timestamps();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
