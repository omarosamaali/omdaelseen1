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
        Schema::create('adds', function (Blueprint $table) {
            $table->id();
            $table->string('type_ar');
            $table->string('type_en')->nullable();
            $table->string('type_zh')->nullable();
            $table->text('details_ar');
            $table->text('details_en')->nullable();
            $table->text('details_zh')->nullable();
            $table->string('image')->nullable();
            $table->float('price');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adds');
    }
};
