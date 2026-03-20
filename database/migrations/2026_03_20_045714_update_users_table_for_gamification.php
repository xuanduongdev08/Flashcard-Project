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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->string('provider_id')->nullable()->after('password')->comment('For Socialite');
            $table->string('learning_goal')->nullable()->after('avatar')->comment('English, Japanese, etc.');
            $table->unsignedBigInteger('xp_points')->default(0)->after('learning_goal');
            $table->unsignedInteger('streak_count')->default(0)->after('xp_points');
            $table->timestamp('last_study_at')->nullable()->after('streak_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'provider_id', 'learning_goal', 'xp_points', 'streak_count', 'last_study_at']);
        });
    }
};
