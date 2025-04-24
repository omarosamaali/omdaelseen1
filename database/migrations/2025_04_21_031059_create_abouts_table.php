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
Schema::create('abouts', function (Blueprint $table) {
    $table->id();
    $table->text('content_ar');
    $table->text('content_en')->nullable();
    $table->text('content_zh')->nullable(); // الصيني
    $table->string('title_ar')->nullable();
    $table->string('title_en')->nullable();
    $table->string('title_zh')->nullable(); // الصيني
    $table->string('avatar')->nullable();
    $table->enum('status', ['نشط', 'غير نشط'])->default('نشط');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
