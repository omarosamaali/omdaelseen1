<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            // المستخدم الذي يتابع
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            // المستخدم الذي يتم متابعته
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // لمنع وجود نفس العلاقة مرتين
            $table->unique(['follower_id', 'following_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};