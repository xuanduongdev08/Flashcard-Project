<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudyController extends Controller
{
    /**
     * Start a study session for the given deck.
     */
    public function session(Deck $deck)
    {

        $deck->load(['language', 'cards' => fn($q) => $q->orderBy('order')]);

        if ($deck->cards->isEmpty()) {
            return redirect()
                ->route('decks.show', $deck)
                ->with('error', '📭 Bộ thẻ này hiện đang trống. Hãy thêm thẻ để bắt đầu học nhé!');
        }

        $cards = $deck->cards;

        return view('study.session', compact('deck', 'cards'));
    }

    /**
     * Finish a study session and award Gamification points.
     */
    public function finish(Request $request, Deck $deck)
    {
        $user = Auth::user();
        $cardCount = $deck->cards()->count();
        
        // --- Calculate XP ---
        // 10 base + 5 per card
        $earnedXp = 10 + ($cardCount * 5);
        $user->xp_points += $earnedXp;

        // --- Calculate Streak ---
        $now = Carbon::now();
        $lastStudy = $user->last_study_at ? Carbon::parse($user->last_study_at) : null;

        if (!$lastStudy) {
            $user->streak_count = 1;
        } else {
            if ($lastStudy->isYesterday()) {
                $user->streak_count += 1;
            } elseif (!$lastStudy->isToday()) {
                // If they missed days (not today and not yesterday)
                $user->streak_count = 1;
            }
            // If they already studied today, keep current streak
        }

        $user->last_study_at = $now;
        $user->save();

        return response()->json([
            'success'   => true,
            'earned_xp' => $earnedXp,
            'new_xp'    => $user->xp_points,
            'streak'    => $user->streak_count,
            'message'   => "Tuyệt vời! Bạn vừa nhận được {$earnedXp} XP. 🔥"
        ]);
    }
}
