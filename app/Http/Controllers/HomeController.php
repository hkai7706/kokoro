<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Like;
use App\Models\Block;
use App\Models\UserMatch;
use App\Models\Message;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Stats
        $matchCount = UserMatch::where('status', 'active')
            ->where(fn ($q) => $q->where('user1_id', $user->id)->orWhere('user2_id', $user->id))
            ->count();
        $likesReceived = Like::where('receiver_id', $user->id)->count();
        $unreadMessages = $user->unreadMessagesCount();

        // Suggested profiles (top 3 by compatibility)
        $blockedIds = $user->blocks()->pluck('blocked_user_id')->toArray();
        $blockedByIds = Block::where('blocked_user_id', $user->id)->pluck('user_id')->toArray();
        $excludeIds = array_merge($blockedIds, $blockedByIds, [$user->id]);

        $suggested = User::where('role', 'user')
            ->where('status', 'active')
            ->whereNotIn('id', $excludeIds)
            ->whereHas('profile', fn ($q) => $q->where('is_complete', true))
            ->with('profile')
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('home', compact('user', 'matchCount', 'likesReceived', 'unreadMessages', 'suggested'));
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $blockedIds = $user->blocks()->pluck('blocked_user_id')->toArray();
        $blockedByIds = Block::where('blocked_user_id', $user->id)->pluck('user_id')->toArray();
        $excludeIds = array_merge($blockedIds, $blockedByIds, [$user->id]);

        $query = User::where('role', 'user')
            ->where('status', 'active')
            ->whereNotIn('id', $excludeIds)
            ->whereHas('profile', fn ($q) => $q->where('is_complete', true))
            ->with('profile');

        $prefectures = app(ProfileController::class)->getPrefectures();

        if ($request->filled('prefecture') && in_array($request->prefecture, $prefectures, true)) {
            $query->whereHas('profile', fn ($q) => $q->where('prefecture', $request->prefecture));
        }
        if ($request->filled('gender') && in_array($request->gender, ['male', 'female', 'other'], true)) {
            $query->whereHas('profile', fn ($q) => $q->where('gender', $request->gender));
        }
        if ($request->filled('min_age')) {
            $minAge = max(18, min(99, (int) $request->min_age));
            $query->whereHas('profile', fn ($q) => $q->where('age', '>=', $minAge));
        }
        if ($request->filled('max_age')) {
            $maxAge = max(18, min(99, (int) $request->max_age));
            $query->whereHas('profile', fn ($q) => $q->where('age', '<=', $maxAge));
        }

        $results = $query->paginate(12)->withQueryString();

        return view('search', compact('results', 'prefectures'));
    }
}
