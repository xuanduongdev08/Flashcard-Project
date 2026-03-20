<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Deck;
use App\Models\Card;
use App\Models\Language;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed languages first
        $this->call(LanguageSeeder::class);

        // 2. Create a default user
        $user = User::factory()->create([
            'name' => 'Nguyen Xuan Duong',
            'email' => 'duong@example.com',
        ]);

        // 3. Create sample decks with cards
        $english = Language::where('code', 'en')->first();
        $vietnamese = Language::where('code', 'vi')->first();

        // English Vocabulary Deck
        $deck1 = Deck::create([
            'user_id' => $user->id,
            'language_id' => $english->id,
            'title' => 'Basic English Vocabulary',
            'description' => 'Essential English words for everyday communication.',
            'color' => '#4F46E5',
        ]);

        $englishCards = [
            ['front' => 'Ubiquitous', 'back' => 'Present, appearing, or found everywhere.', 'order' => 1],
            ['front' => 'Ephemeral', 'back' => 'Lasting for a very short time.', 'order' => 2],
            ['front' => 'Pragmatic', 'back' => 'Dealing with things sensibly and realistically.', 'order' => 3],
            ['front' => 'Eloquent', 'back' => 'Fluent or persuasive in speaking or writing.', 'order' => 4],
            ['front' => 'Resilient', 'back' => 'Able to recover quickly from difficulties.', 'order' => 5],
        ];

        foreach ($englishCards as $card) {
            $deck1->cards()->create($card);
        }

        // Vietnamese Vocabulary Deck
        $deck2 = Deck::create([
            'user_id' => $user->id,
            'language_id' => $vietnamese->id,
            'title' => 'Từ Vựng Tiếng Việt',
            'description' => 'Các từ vựng tiếng Việt quan trọng và hay sử dụng.',
            'color' => '#8B5CF6',
        ]);

        $vietnameseCards = [
            ['front' => 'Hạnh phúc', 'back' => 'Happiness - trạng thái vui vẻ, mãn nguyện.', 'order' => 1],
            ['front' => 'Kiên trì', 'back' => 'Perseverance - không bỏ cuộc trước khó khăn.', 'order' => 2],
            ['front' => 'Sáng tạo', 'back' => 'Creative - khả năng tạo ra cái mới.', 'order' => 3],
            ['front' => 'Tri thức', 'back' => 'Knowledge - hiểu biết thu được qua học tập.', 'order' => 4],
        ];

        foreach ($vietnameseCards as $card) {
            $deck2->cards()->create($card);
        }
    }
}
