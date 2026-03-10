<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function inbox()
    {
        $user = auth()->user();
        $matches = $user->getAllMatches();

        $conversations = [];
        foreach ($matches as $match) {
            $partner = $match->getPartner($user->id);
            $partner->load('profile');

            $lastMessage = Message::where(function ($q) use ($user, $partner) {
                $q->where('sender_id', $user->id)->where('receiver_id', $partner->id);
            })->orWhere(function ($q) use ($user, $partner) {
                $q->where('sender_id', $partner->id)->where('receiver_id', $user->id);
            })->latest()->first();

            $unreadCount = Message::where('sender_id', $partner->id)
                ->where('receiver_id', $user->id)
                ->whereNull('read_at')
                ->count();

            $conversations[] = [
                'partner' => $partner,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount,
                'match' => $match,
            ];
        }

        // Sort by last message time
        usort($conversations, function ($a, $b) {
            $aTime = $a['last_message'] ? $a['last_message']->created_at->timestamp : 0;
            $bTime = $b['last_message'] ? $b['last_message']->created_at->timestamp : 0;
            return $bTime - $aTime;
        });

        return view('messages.inbox', compact('conversations'));
    }

    public function conversation($userId)
    {
        $user = auth()->user();
        $partner = User::with('profile')->findOrFail($userId);

        // Check if they are matched
        if (!$user->isMatchedWith($partner->id)) {
            return redirect()->route('messages.inbox')
                ->with('error', 'You can only message matched users.');
        }

        // Get messages
        $messages = Message::where(function ($q) use ($user, $partner) {
            $q->where('sender_id', $user->id)->where('receiver_id', $partner->id);
        })->orWhere(function ($q) use ($user, $partner) {
            $q->where('sender_id', $partner->id)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        // Mark unread messages as read
        Message::where('sender_id', $partner->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.conversation', compact('messages', 'partner'));
    }

    public function send(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $user = auth()->user();
        $partner = User::findOrFail($userId);

        if (!$user->isMatchedWith($partner->id)) {
            return back()->with('error', 'You can only message matched users.');
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $partner->id,
            'message' => e($request->message), // XSS protection
        ]);

        Notification::create([
            'user_id' => $partner->id,
            'type' => 'message',
            'content' => $user->name . ' sent you a message.',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'sent', 'message' => $message]);
        }

        return back();
    }

    public function getNewMessages(Request $request, $userId)
    {
        $lastId = $request->query('after', 0);
        $user = auth()->user();

        $messages = Message::where('id', '>', $lastId)
            ->where(function ($q) use ($user, $userId) {
                $q->where(function ($q2) use ($user, $userId) {
                    $q2->where('sender_id', $user->id)->where('receiver_id', $userId);
                })->orWhere(function ($q2) use ($user, $userId) {
                    $q2->where('sender_id', $userId)->where('receiver_id', $user->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages->map(function ($msg) use ($user) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'is_mine' => $msg->sender_id === $user->id,
                'time' => $msg->created_at->format('H:i'),
                'date' => $msg->created_at->format('M d'),
            ];
        }));
    }
}
