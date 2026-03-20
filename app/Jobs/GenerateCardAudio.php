<?php

namespace App\Jobs;

use App\Models\Card;
use App\Services\TTSService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateCardAudio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $card;

    /**
     * Create a new job instance.
     */
    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    /**
     * Execute the job.
     */
    public function handle(TTSService $ttsService)
    {
        // Lấy mã ngôn ngữ từ Deck thông qua quan hệ
        $language = $this->card->deck->language;
        $ttsCode = $language->tts_code;

        if (!$ttsCode) return;

        // Nội dung cần đọc (Mặt trước)
        $text = $this->card->front;
        
        // Tạo tên file độc nhất (dựa trên card id và nội dung để tránh trùng)
        $filename = "card_" . $this->card->id . "_" . Str::slug(Str::limit($text, 20)) . ".mp3";

        // Gọi AI TTS để tạo file
        $audioPath = $ttsService->generateSpeech($text, $ttsCode, $filename);

        if ($audioPath) {
            $this->card->update(['audio_path' => $audioPath]);
        }
    }
}
