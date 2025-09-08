<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToReviewReportsTable extends Migration
{
    public function up()
    {
        Schema::table('review_reports', function (Blueprint $table) {
            $table->integer('status')->default(1)->after('report_type');
        });
    }

    public function down()
    {
        Schema::table('review_reports', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
