<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            // 1. فك الـ foreign keys مؤقتًا
            $table->dropForeign(['user_id']);
            $table->dropForeign(['place_id']);

            // 2. شيل الـ primary key المركب
            $table->dropPrimary(['user_id', 'place_id']);

            // 3. أضف عمود id
            $table->id()->first();

            // 4. رجّع الـ foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            // 1. فك الـ foreign keys اللي لسه مضافة
            $table->dropForeign(['user_id']);
            $table->dropForeign(['place_id']);

            // 2. شيل العمود id
            $table->dropColumn('id');

            // 3. رجّع الـ primary key المركب
            $table->primary(['user_id', 'place_id']);

            // 4. رجّع الـ foreign keys زي الأول
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });
    }
};
