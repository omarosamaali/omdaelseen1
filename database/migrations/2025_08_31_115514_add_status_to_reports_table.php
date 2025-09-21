<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToReportsTable extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('status', ['pending', 'resolved', 'dismissed'])->default('pending')->after('report_type');
            $table->timestamp('resolved_at')->nullable()->after('status');
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null')->after('resolved_at');
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            // حذف القيد الأجنبي أولاً
            $table->dropForeign(['resolved_by']);
            // حذف الأعمدة
            $table->dropColumn(['status', 'resolved_at', 'resolved_by']);
        });
    }
}
