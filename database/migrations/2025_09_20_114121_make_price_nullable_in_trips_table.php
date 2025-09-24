<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        // Before reverting, ensure no NULL values exist if making it NOT NULL
        DB::table('trips')
            ->whereNull('price')
            ->update(['price' => 0.00]); // or some default value

        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable(false)->change();
        });
    }
};
