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
        Schema::create('pending_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('country', 2);
            $table->string('password');
            $table->unsignedBigInteger('trip_id');
            $table->enum('room_type', ['private', 'shared']);
            $table->decimal('amount', 10, 2);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->index(['payment_id', 'created_at']);
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_bookings');
    }
};
