<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWordZhAudioToHelpWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('help_words', function (Blueprint $table) {
            $table->string('word_zh_audio')->nullable()->after('word_zh');
            // يمكنك إضافة المزيد من الأعمدة هنا إذا لزم الأمر
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('help_words', function (Blueprint $table) {
            $table->dropColumn('word_zh_audio');
            // إذا أضفت المزيد من الأعمدة في دالة up()، قم بإسقاطها هنا
        });
    }
}