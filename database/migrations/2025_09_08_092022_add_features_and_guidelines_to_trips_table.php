<?php

// database/migrations/xxxx_xx_xx_add_features_and_guidelines_to_trips_table.php

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
        Schema::table('trips', function (Blueprint $table) {
            $table->text('trip_features')->after('price')->nullable();
            $table->text('trip_guidelines')->after('trip_features')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('trip_features');
            $table->dropColumn('trip_guidelines');
        });
    }
};