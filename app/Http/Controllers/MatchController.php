<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Block;
use App\Models\Report;
use App\Models\User;
use App\Models\UserMatch;
use App\Models\Notification;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function like(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);

        $senderId = auth()->id();
        $receiverId = $request->user_id;

        if ($senderId == $receiverId) {
            return back()->with('error', 'You cannot like yourself.');
        }

        // Check if blocked
        if (auth()->user()->hasBlocked($receiverId)) {
            return back()->with('error', 'You have blocked this user.');
        }

        Like::firstOrCreate([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
        ]);

        // Check if mutual like exists
        $mutualLike = Like::where('sender_id', $receiverId)
            ->where('receiver_id', $senderId)
            ->exists();

        if ($mutualLike) {
            $user1 = min($senderId, $receiverId);
            $user2 = max($senderId, $receiverId);

            UserMatch::firstOrCreate(
                ['user1_id' => $user1, 'user2_id' => $user2],
                ['status' => 'active']
            );

            Notification::create([
                'user_id' => $senderId,
                'type' => 'match',
                'content' => 'You have a new match! Start chatting now.',
            ]);
            Notification::create([
                'user_id' => $receiverId,
                'type' => 'match',
                'content' => 'You have a new match! Start chatting now.',
            ]);

            if ($request->expectsJson()) {
                return response()->json(['status' => 'matched', 'message' => "It's a match!"]);
            }
            return back()->with('success', "It's a match! You can now message each other.");
        }

        Notification::create([
            'user_id' => $receiverId,
            'type' => 'like',
            'content' => 'Someone liked your profile!',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'liked', 'message' => 'Like sent!']);
        }
        return back()->with('success', 'Like sent!');
    }

    public function unlike(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);

        Like::where('sender_id', auth()->id())
            ->where('receiver_id', $request->user_id)
            ->delete();

        $user1 = min(auth()->id(), $request->user_id);
        $user2 = max(auth()->id(), $request->user_id);
        UserMatch::where('user1_id', $user1)->where('user2_id', $user2)->delete();

        if ($request->expectsJson()) {
            return response()->json(['status' => 'unliked']);
        }
        return back()->with('info', 'Like removed.');
    }

    public function skip(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => 'skipped']);
        }
        return back();
    }

    public function liked()
    {
        $likedUserIds = auth()->user()->sentLikes()->pluck('receiver_id');
        $likedUsers = User::whereIn('id', $likedUserIds)->with('profile')->paginate(12);
        return view('liked', compact('likedUsers'));
    }

    // ── Who Liked Me ──

    public function whoLikedMe()
    {
        $user = auth()->user();
        $likerIds = Like::where('receiver_id', $user->id)->pluck('sender_id');
        $likers = User::whereIn('id', $likerIds)
            ->with('profile')
            ->paginate(12);

        return view('who-liked-me', compact('likers'));
    }

    // ── Block ──

    public function block(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);
        $userId = $request->user_id;

        if (auth()->id() == $userId) {
            return back()->with('error', 'You cannot block yourself.');
        }

        Block::firstOrCreate([
            'user_id' => auth()->id(),
            'blocked_user_id' => $userId,
        ]);

        // Remove likes and matches with this user
        Like::where(function ($q) use ($userId) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', auth()->id());
        })->delete();

        $u1 = min(auth()->id(), $userId);
        $u2 = max(auth()->id(), $userId);
        UserMatch::where('user1_id', $u1)->where('user2_id', $u2)->delete();

        return back()->with('info', 'User has been blocked.');
    }

    public function unblock(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);

        Block::where('user_id', auth()->id())
            ->where('blocked_user_id', $request->user_id)
            ->delete();

        return back()->with('success', 'User has been unblocked.');
    }

    // ── Report ──

    public function report(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'reason' => 'required|string|max:500',
            'details' => 'nullable|string|max:2000',
            'message_id' => 'nullable|integer|exists:messages,id',
        ]);

        if (auth()->id() == $request->user_id) {
            return back()->with('error', 'You cannot report yourself.');
        }

        // Prevent duplicate pending reports
        $existingReport = Report::where('reporter_id', auth()->id())
            ->where('reported_user_id', $request->user_id)
            ->where('status', 'pending')
            ->exists();

        if ($existingReport) {
            return back()->with('info', 'You already have a pending report for this user.');
        }

        Report::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $request->user_id,
            'reason' => e($request->reason),
            'details' => $request->details ? e($request->details) : null,
            'message_id' => $request->message_id,
            'status' => 'pending',
        ]);

        Notification::create([
            'user_id' => auth()->id(),
            'type' => 'report',
            'content' => 'Your report has been submitted and will be reviewed.',
        ]);

        return back()->with('success', 'Report submitted. Our team will review it.');
    }
}
