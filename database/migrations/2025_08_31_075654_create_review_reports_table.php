<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewReportsTable extends Migration
{
    public function up()
    {
        Schema::create('review_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('place_id')->constrained('places')->onDelete('cascade');
            $table->foreignId('review_id')->constrained('ratings')->onDelete('cascade');
            $table->string('report_type'); // e.g., 'review_report'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('review_reports');
    }
}
