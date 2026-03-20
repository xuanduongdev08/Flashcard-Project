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
     * Get all decks for this language.
     * Relationship: One Language has Many Decks.
     */
    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class);
    }
}
