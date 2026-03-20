<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table: languages
     * Stores supported languages for flashcard decks.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // e.g. "English", "Vietnamese"
            $table->string('code', 10);      // e.g. "en", "vi", "ja"
            $table->string('flag_emoji', 10)->nullable(); // e.g. "🇺🇸", "🇻🇳"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
