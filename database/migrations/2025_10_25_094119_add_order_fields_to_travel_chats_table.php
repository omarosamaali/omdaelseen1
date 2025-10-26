<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('travel_chats', function (Blueprint $table) {
            $table->string('order_type')->nullable()->after('trip_id');
            $table->unsignedBigInteger('order_id')->nullable()->after('order_type');
        });
    }

    public function down(): void
    {
        Schema::table('travel_chats', function (Blueprint $table) {
            $table->dropColumn(['order_type', 'order_id']);
        });
    }
};
