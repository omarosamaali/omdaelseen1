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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('title_ch');
            $table->date('departure_date');
            $table->date('return_date');
            $table->string('hotel_ar');
            $table->string('hotel_en');
            $table->string('hotel_ch');
            $table->string('transportation_type');
            $table->string('trip_type');
            $table->string('room_type');
            $table->decimal('shared_room_price', 8, 2)->nullable();
            $table->decimal('private_room_price', 8, 2)->nullable();
            $table->string('translators')->nullable();
            $table->json('meals')->nullable(); // لحفظ وجبات الطعام كـJSON
            $table->boolean('airport_pickup')->default(false);
            $table->boolean('supervisor')->default(false);
            $table->boolean('factory_visit')->default(false);
            $table->boolean('tourist_sites_visit')->default(false);
            $table->boolean('markets_visit')->default(false);
            $table->boolean('tickets_included')->default(false);
            $table->decimal('price', 8, 2);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
