<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome'); // A simple landing page
})->name('home');

// Auth AJAX Routes
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password/send-otp', [AuthController::class, 'sendOtp'])->name('password.email');
Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verify');
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password/update', [AuthController::class, 'resetPassword'])->name('password.update');

// Google Socialite
Route::get('/auth/google', [AuthController::class, 'googleRedirect'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);

// --- Protected Routes ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Onboarding
    Route::post('/user/update-goal', [AuthController::class, 'updateGoal'])->name('user.update-goal');

    // Deck CRUD
    Route::resource('decks', DeckController::class);
    Route::post('decks/{deck}/clone', [DeckController::class, 'clone'])->name('decks.clone');

    // Cards CRUD (nested under decks)
    Route::prefix('decks/{deck}/cards')->name('decks.cards.')->group(function () {
        Route::get('create',         [CardController::class, 'create'])->name('create');
        Route::post('/',             [CardController::class, 'store'])->name('store');
        Route::get('{card}/edit',    [CardController::class, 'edit'])->name('edit');
        Route::put('{card}',         [CardController::class, 'update'])->name('update');
        Route::delete('{card}',      [CardController::class, 'destroy'])->name('destroy');
    });

    // Study session for a deck
    Route::get('decks/{deck}/study', [StudyController::class, 'session'])->name('study.session');
    Route::post('decks/{deck}/study/finish', [StudyController::class, 'finish'])->name('study.finish');

    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Route tạm thời để cập nhật Database trên Render Free
Route::get('/update-database-xd', function() {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "Cập nhật dữ liệu thành công! Bạn có thể xóa route này bây giờ.";
    } catch (\Exception $e) {
        return "Lỗi: " . $e->getMessage();
    }
});
