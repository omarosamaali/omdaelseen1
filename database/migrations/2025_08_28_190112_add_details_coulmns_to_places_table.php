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
        Schema::table('places', function (Blueprint $table) {
            $table->text('details_ar')->nullable();
            $table->text('details_en')->nullable();
            $table->text('details_ch')->nullable();

            $table->string('website')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn('details_ar');
            $table->dropColumn('details_en');
            $table->dropColumn('details_ch');
        });
    }
};
