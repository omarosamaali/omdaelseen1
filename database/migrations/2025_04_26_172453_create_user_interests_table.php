<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInterestsTable extends Migration
{
    public function up()
    {
        Schema::create('user_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table
            $table->string('interest_type'); // e.g., 'exhibition', 'event', 'help_word'
            $table->unsignedBigInteger('interest_id'); // ID of the specific item (e.g., exhibition ID)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_interests');
    }
}