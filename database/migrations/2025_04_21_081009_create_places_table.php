<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('name_ch');
            $table->foreignId('main_category_id')->constrained('explorers')->onDelete('cascade'); // Foreign key to explorers table
            $table->foreignId('sub_category_id')->constrained('branches')->onDelete('cascade'); // Foreign key to branches table
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade'); // Foreign key to regions table
            $table->string('link');
            $table->enum('map_type', ['baidu', 'google', 'apple']);
            $table->string('avatar')->nullable();
            $table->json('additional_images')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('details')->nullable();
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};