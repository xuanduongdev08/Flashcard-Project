<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard with all decks belonging to the user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Languages for the filter
        $languages = Language::withCount('decks')->get();

        // Base Query: Only user's decks
        $query = $user->decks()->with(['language', 'cards'])
            ->withCount('cards');

        // Multi-select Language Filter
        if ($request->filled('language')) {
            $langs = is_array($request->language) ? $request->language : explode(',', $request->language);
            $query->whereIn('language_id', $langs);
        }

        // Search Filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $decks = $query->latest()->get();

        // Recently Studied (Basic logic: latest updated decks with cards)
        $recentlyStudied = $user->decks()
            ->whereHas('cards')
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        // AI Recommendation (Based on user goal)
        $learningGoal = $user->learning_goal ?? 'English';
        $recommended = Deck::whereHas('language', function($q) use ($learningGoal) {
                $q->where('name', 'like', "%$learningGoal%");
            })
            ->where('user_id', '!=', $user->id) // Recommend others' decks if public, or just samples
            ->withCount('cards')
            ->take(2)
            ->get();

        $selectedLanguage = (array) $request->language;

        return view('dashboard', compact('decks', 'languages', 'selectedLanguage', 'recentlyStudied', 'recommended'));
    }
}
