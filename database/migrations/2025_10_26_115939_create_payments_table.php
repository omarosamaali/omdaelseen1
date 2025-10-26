<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // المستخدم اللي دفع
            $table->foreignId('order_id')->constrained('adds')->onDelete('cascade'); // ID العنصر (مثلاً إعلان)
            $table->string('order_type')->nullable(); // نوع العنصر (adds, trip, subscription...)
            $table->decimal('amount', 10, 2); // المبلغ
            $table->string('currency', 10)->default('AED');
            $table->string('payment_reference')->nullable(); // رقم مرجع Ziina
            $table->string('status')->default('pending'); // pending / paid / failed
            $table->string('payment_method')->nullable(); // بطاقة / Apple Pay / إلخ
            $table->json('gateway_response')->nullable(); // البيانات القادمة من Ziina
            $table->string('reference_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
