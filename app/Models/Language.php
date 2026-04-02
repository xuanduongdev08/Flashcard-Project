<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'flag_emoji',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['flag_url'];

    /**
     * Get the flag image URL from flagcdn.com.
     * This provides a consistent and premium look across all platforms (Windows, macOS, Mobile).
     */
    public function getFlagUrlAttribute(): string
    {
        // Many language codes (en, ja, ko) match the country codes (us/gb, jp, kr)
        // Some might need special mapping.
        $mapping = [
            'en' => 'us', // Default English to US flag
            'ko' => 'kr',
            'ja' => 'jp',
            'vi' => 'vn',
            'zh' => 'cn',
            'de' => 'de',
            'fr' => 'fr',
            'es' => 'es',
            'it' => 'it',
            'ru' => 'ru',
        ];

        $code = strtolower($this->code);
        $countryCode = $mapping[$code] ?? $code;

        return "https://flagcdn.com/w80/{$countryCode}.png";
    }

    /**
     * Get all decks for this language.
     * Relationship: One Language has Many Decks.
     */
    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class);
    }
}
