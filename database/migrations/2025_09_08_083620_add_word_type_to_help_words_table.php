<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // In the migration file (e.g., 2023_..._add_word_type_to_help_words_table.php)

    public function up()
    {
        Schema::table('help_words', function (Blueprint $table) {
            $table->string('word_type')->after('order')->nullable();
        });
    }

    public function down()
    {
        Schema::table('help_words', function (Blueprint $table) {
            $table->dropColumn('word_type');
        });
    }
};
