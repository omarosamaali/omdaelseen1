<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('travel_chats', function (Blueprint $table) {
            $table->dropForeign(['trip_id']);
            $table->unsignedBigInteger('trip_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('travel_chats', function (Blueprint $table) {
            $table->foreign('trip_id')
                ->references('id')
                ->on('trip_requests')
                ->onDelete('cascade');
        });
    }
};
