<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingNotesTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_notes', function (Blueprint $table) {
            $table->id();
            $table->string('note_number')->unique();
            $table->morphs('order'); // Polymorphic relationship to TripRequest or Product
            $table->date('note_date');
            $table->string('title');
            $table->text('details');
            $table->string('file_path')->nullable();
            $table->enum('status', ['التجهيز للشحن', 'تم الشحن']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_notes');
    }
}
