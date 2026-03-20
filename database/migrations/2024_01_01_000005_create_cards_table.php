<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table: cards
     * Stores individual flashcards. Each card belongs to a deck.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deck_id')->constrained()->onDelete('cascade');
            $table->string('front');      // Front side of the card (question/word)
            $table->text('back');         // Back side of the card (answer/meaning)
            $table->integer('order')->default(0); // Display order within deck
            $table->timestamps();

            // Index for performance
            $table->index('deck_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
