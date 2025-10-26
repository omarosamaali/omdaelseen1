<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('payments');
    }

    public function down()
    {
        // لو عايز ترجع الجدول
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // الأعمدة القديمة
            $table->timestamps();
        });
    }
};
