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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete(); // الربط بجدول الطلبات الأساسي
            $table->string('link')->nullable(); // رابط المنتج
            $table->integer('quantity'); // الكمية
            $table->decimal('price', 8, 2)->nullable(); // السعر المتوقع للحبة
            $table->string('size')->nullable(); // الحجم
            $table->string('color')->nullable(); // اللون
            $table->text('notes')->nullable(); // تفاصيل إضافية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
