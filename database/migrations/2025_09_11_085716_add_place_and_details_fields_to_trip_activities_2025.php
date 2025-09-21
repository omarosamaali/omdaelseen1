<?php

// database/migrations/2025_09_11_XXXXXX_add_place_and_details_fields_to_trip_activities_2025.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlaceAndDetailsFieldsToTripActivities2025 extends Migration
{
    public function up()
    {
        Schema::table('trip_activities', function (Blueprint $table) {
            $table->boolean('is_place_related')->default(false);
            $table->unsignedBigInteger('place_id')->nullable();
            $table->string('place_name_ar')->nullable();
            $table->string('place_name_en')->nullable();
            $table->string('place_name_zh')->nullable();
            $table->text('details_ar')->nullable();
            $table->text('details_en')->nullable();
            $table->text('details_zh')->nullable();

            $table->foreign('place_id')->references('id')->on('places')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('trip_activities', function (Blueprint $table) {
            $table->dropForeign(['place_id']);
            $table->dropColumn([
                'is_place_related',
                'place_id',
                'place_name_ar',
                'place_name_en',
                'place_name_zh',
                'details_ar',
                'details_en',
                'details_zh'
            ]);
        });
    }
}