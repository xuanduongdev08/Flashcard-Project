<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Seed the languages table with default languages.
     */
    public function run(): void
    {
        $languages = [
            ['name' => 'English',    'code' => 'en', 'flag_emoji' => '🇺🇸'],
            ['name' => 'Vietnamese', 'code' => 'vi', 'flag_emoji' => '🇻🇳'],
            ['name' => 'Japanese',   'code' => 'ja', 'flag_emoji' => '🇯🇵'],
            ['name' => 'Korean',     'code' => 'ko', 'flag_emoji' => '🇰🇷'],
            ['name' => 'French',     'code' => 'fr', 'flag_emoji' => '🇫🇷'],
            ['name' => 'Chinese',    'code' => 'zh', 'flag_emoji' => '🇨🇳'],
            ['name' => 'Spanish',    'code' => 'es', 'flag_emoji' => '🇪🇸'],
            ['name' => 'German',     'code' => 'de', 'flag_emoji' => '🇩🇪'],
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(
                ['code' => $language['code']],
                $language
            );
        }
    }
}
