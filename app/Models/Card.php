<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $appends = ['audio_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'deck_id',
        'front',
        'back',
        'order',
        'audio_path',
    ];

    /**
     * Get the full URL for the audio file.
     */
    public function getAudioUrlAttribute()
    {
        return $this->audio_path ? asset('storage/' . $this->audio_path) : null;
    }

    /**
     * Get the deck that this card belongs to.
     * Relationship: Card belongs to Deck.
     */
    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class);
    }
}
