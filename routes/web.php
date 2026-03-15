<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;

// ─────────────────────────────────────────────
//  PUBLIC ROUTES
// ─────────────────────────────────────────────

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    }
    return view('landing');
})->name('landing');

// Auth
Route::get('/auth', [AuthController::class, 'show'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('throttle:5,1');
Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─────────────────────────────────────────────
//  AUTHENTICATED USER ROUTES
// ─────────────────────────────────────────────

Route::middleware(['auth', \App\Http\Middleware\CheckBanned::class])->group(function () {

    // Profile creation (before profile-complete middleware)
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');

    // Routes requiring completed profile
    Route::middleware([\App\Http\Middleware\EnsureProfileComplete::class])->group(function () {

        // Home / Discover
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/search', [HomeController::class, 'search'])->name('search');

        // Profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/user/{id}', [ProfileController::class, 'viewUser'])->name('user.profile');

        // Matching (rate limited: 60 likes per hour)
        Route::post('/like', [MatchController::class, 'like'])->name('match.like')->middleware('throttle:60,60');
        Route::post('/unlike', [MatchController::class, 'unlike'])->name('match.unlike');
        Route::post('/skip', [MatchController::class, 'skip'])->name('match.skip');
        Route::get('/liked', [MatchController::class, 'liked'])->name('liked');
        Route::get('/who-liked-me', [MatchController::class, 'whoLikedMe'])->name('who.liked.me');

        // Block & Report (rate limited)
        Route::post('/block', [MatchController::class, 'block'])->name('user.block')->middleware('throttle:30,60');
        Route::post('/unblock', [MatchController::class, 'unblock'])->name('user.unblock')->middleware('throttle:30,60');
        Route::post('/report', [MatchController::class, 'report'])->name('user.report')->middleware('throttle:10,60');

        // Messages (rate limited: 30 messages per minute)
        Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
        Route::get('/messages/{userId}', [MessageController::class, 'conversation'])->name('messages.conversation');
        Route::post('/messages/{userId}', [MessageController::class, 'send'])->name('messages.send')->middleware('throttle:30,1');
        Route::get('/messages/{userId}/new', [MessageController::class, 'getNewMessages'])->name('messages.new');
    });
});

// ─────────────────────────────────────────────
//  ADMIN ROUTES
// ─────────────────────────────────────────────

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post')->middleware('throttle:5,1');

    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Users
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/users/{id}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');
        Route::post('/users/{id}/unban', [AdminController::class, 'unbanUser'])->name('admin.users.unban');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

        // Matches
        Route::get('/matches', [AdminController::class, 'matches'])->name('admin.matches');

        // Reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::post('/reports/{id}/review', [AdminController::class, 'reviewReport'])->name('admin.reports.review');
        Route::post('/reports/{id}/resolve', [AdminController::class, 'resolveReport'])->name('admin.reports.resolve');

        // Messages
        Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
    });
});
