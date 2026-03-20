<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('tts_code')->nullable()->after('flag_emoji');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->string('audio_path')->nullable()->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn('tts_code');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('audio_path');
        });
    }
};
