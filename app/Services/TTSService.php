<?php

namespace App\Services;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class TTSService
{
    protected $client;

    public function __construct()
    {
        // Khởi tạo client. Laravel sẽ tự động lấy GOOGLE_APPLICATION_CREDENTIALS nếu cấu hình đúng trong .env
        if (class_exists(TextToSpeechClient::class)) {
            try {
                $this->client = new TextToSpeechClient();
            } catch (Exception $e) {
                Log::error("TTS Init Error: " . $e->getMessage());
            }
        }
    }

    /**
     * Chuyển đổi văn bản thành âm thanh và lưu vào storage.
     */
    public function generateSpeech($text, $ttsCode, $filename)
    {
        if (!$this->client) return null;

        try {
            $input = new SynthesisInput();
            $input->setText($text);

            $voice = new VoiceSelectionParams();
            $voice->setLanguageCode($ttsCode);
            
            // Tùy chỉnh giọng đọc cho tự nhiên hơn
            $bestVoice = $this->getBestVoice($ttsCode);
            if ($bestVoice) {
                $voice->setName($bestVoice);
            }

            $audioConfig = new AudioConfig();
            $audioConfig->setAudioEncoding(AudioEncoding::MP3);

            $response = $this->client->synthesizeSpeech($input, $voice, $audioConfig);
            $audioContent = $response->getAudioContent();

            $path = "audio/cards/{$filename}";
            Storage::disk('public')->put($path, $audioContent);

            return $path;
        } catch (Exception $e) {
            Log::error("TTS Generation Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Trả về tên giọng đọc tốt nhất cho từng ngôn ngữ.
     */
    protected function getBestVoice($ttsCode)
    {
        $voices = [
            'vi-VN' => 'vi-VN-Wavenet-A', // Giọng nữ Việt Nam cao cấp
            'en-US' => 'en-US-Neural2-F', // Giọng Mỹ tự nhiên
            'ja-JP' => 'ja-JP-Wavenet-C', // Giọng Nhật
            'ko-KR' => 'ko-KR-Wavenet-A',
            'fr-FR' => 'fr-FR-Wavenet-C',
            'zh-CN' => 'zh-CN-Wavenet-A',
            'es-ES' => 'es-ES-Wavenet-B',
            'de-DE' => 'de-DE-Wavenet-A',
        ];

        return $voices[$ttsCode] ?? null;
    }
}
