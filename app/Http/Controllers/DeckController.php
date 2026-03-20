<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{
    /**
     * Private helper to authorize user.
     */
    private function authorizeUser(Deck $deck)
    {
        if ($deck->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập bộ thẻ này.');
        }
    }

    /**
     * Display a listing of the user's decks.
     */
    public function index()
    {
        $decks = Auth::user()
            ->decks()
            ->with('language')
            ->withCount('cards')
            ->orderByDesc('updated_at')
            ->get();

        return view('decks.index', compact('decks'));
    }

    /**
     * Store a newly created deck.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'language_id' => 'required|exists:languages,id',
            'color'       => 'required|string|size:7',
        ]);

        $deck = Auth::user()->decks()->create($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', '🎉 Đã tạo bộ thẻ "' . $deck->title . '" thành công!');
    }

    public function create()
    {
        $languages = Language::all();
        return view('decks.create', compact('languages'));
    }

    public function show(Deck $deck)
    {
        $deck->load(['language', 'cards' => fn($q) => $q->orderBy('order')]);
        return view('decks.show', compact('deck'));
    }

    public function edit(Deck $deck)
    {
        $this->authorizeUser($deck);
        $languages = Language::all();
        return view('decks.edit', compact('deck', 'languages'));
    }

    public function update(Request $request, Deck $deck)
    {
        $this->authorizeUser($deck);
        
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'language_id' => 'required|exists:languages,id',
            'color'       => 'required|string|size:7',
        ]);

        $deck->update($validated);

        return redirect()
            ->route('decks.show', $deck)
            ->with('success', '✅ Đã cập nhật thông tin bộ thẻ!');
    }

    public function destroy(Deck $deck)
    {
        $this->authorizeUser($deck);
        $title = $deck->title;
        $deck->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', '🗑️ Đã xóa bộ thẻ "' . $title . '" thành công.');
    }

    /**
     * Sao chép bộ thẻ (Clone) từ cộng đồng/AI về tài khoản của mình.
     */
    public function clone(Deck $deck)
    {
        $newDeck = Auth::user()->decks()->create([
            'title'       => $deck->title . ' (Bản sao)',
            'description' => $deck->description,
            'language_id' => $deck->language_id,
            'color'       => $deck->color,
        ]);

        foreach ($deck->cards as $card) {
            $newDeck->cards()->create([
                'front'     => $card->front,
                'back'      => $card->back,
                'order'     => $card->order,
                'audio_url' => $card->audio_url,
            ]);
        }

        return redirect()
            ->route('decks.show', $newDeck)
            ->with('success', '✨ Đã lưu bộ thẻ thành công. Bây giờ bộ thẻ này là của bạn, hãy thoải mái tùy chỉnh nhé!');
    }
}
