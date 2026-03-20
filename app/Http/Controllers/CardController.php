<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use App\Jobs\GenerateCardAudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    /**
     * Private helper to authorize user via deck.
     */
    private function authorizeDeck(Deck $deck)
    {
        if ($deck->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền quản lý thẻ trong bộ sưu tập này.');
        }
    }

    public function create(Deck $deck)
    {
        $this->authorizeDeck($deck);
        return view('cards.create', compact('deck'));
    }

    public function store(Request $request, Deck $deck)
    {
        $this->authorizeDeck($deck);

        $validated = $request->validate([
            'front' => 'required|string|max:255',
            'back'  => 'required|string|max:2000',
            'order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['order'])) {
            $validated['order'] = $deck->cards()->max('order') + 1;
        }

        $card = $deck->cards()->create($validated);

        GenerateCardAudio::dispatch($card);

        return redirect()
            ->route('decks.show', $deck)
            ->with('success', '✅ Đã thêm thẻ mới thành công!');
    }

    public function edit(Deck $deck, Card $card)
    {
        $this->authorizeDeck($deck);
        return view('cards.edit', compact('deck', 'card'));
    }

    public function update(Request $request, Deck $deck, Card $card)
    {
        $this->authorizeDeck($deck);
        
        $validated = $request->validate([
            'front' => 'required|string|max:255',
            'back'  => 'required|string|max:2000',
            'order' => 'nullable|integer|min:0',
        ]);

        $card->update($validated);
        
        GenerateCardAudio::dispatch($card);

        return redirect()
            ->route('decks.show', $deck)
            ->with('success', '✅ Đã cập nhật nội dung thẻ!');
    }

    public function destroy(Deck $deck, Card $card)
    {
        $this->authorizeDeck($deck);
        $card->delete();

        return redirect()
            ->route('decks.show', $deck)
            ->with('success', '🗑️ Đã xóa thẻ.');
    }
}
