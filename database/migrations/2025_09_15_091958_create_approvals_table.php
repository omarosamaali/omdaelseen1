<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->string('approval_number')->unique();
            $table->morphs('order'); // Polymorphic relationship to TripRequest or Product
            $table->date('approval_date');
            $table->string('title');
            $table->text('details');
            $table->string('file_path')->nullable();
            $table->string('status')->default('يحتاج الموافقة');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}
