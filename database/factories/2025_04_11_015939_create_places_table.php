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
            $table->unsignedBigInteger('user_id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('name_ch');
            $table->unsignedBigInteger('main_category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('region_id');
            $table->string('link');
            $table->enum('map_type', ['baidu', 'google', 'apple']);
            $table->string('avatar');
            $table->json('additional_images')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('details')->nullable();
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->timestamps();
        });

        Schema::table('places', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('main_category_id')->references('id')->on('explorers')->onDelete('restrict');
            $table->foreign('sub_category_id')->references('id')->on('branches')->onDelete('restrict');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};