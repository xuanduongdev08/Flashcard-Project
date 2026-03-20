<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deck extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'language_id',
        'title',
        'description',
        'color',
    ];

    /**
     * Get the user that owns the deck.
     * Relationship: Deck belongs to User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the language of this deck.
     * Relationship: Deck belongs to Language.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get all cards in this deck.
     * Relationship: One Deck has Many Cards.
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class)->orderBy('order');
    }

    /**
     * Get the total number of cards in this deck.
     */
    public function getCardCountAttribute(): int
    {
        return $this->cards()->count();
    }
}
