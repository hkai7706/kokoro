@extends('layouts.app')
@section('title', 'Messages - KOKORO')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-5" data-en="Messages" data-jp="メッセージ">Messages</h1>

    @if(count($conversations) > 0)
        <div class="card divide-y divide-gray-50 dark:divide-gray-700/50">
            @foreach($conversations as $convo)
                <a href="{{ route('messages.conversation', $convo['partner']->id) }}"
                   class="flex items-center gap-3.5 px-4 py-3.5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition {{ $convo['unread_count'] > 0 ? 'bg-rose-50/40 dark:bg-rose-900/10' : '' }}">
                    <div class="relative shrink-0">
                        <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden border-2 {{ $convo['unread_count'] > 0 ? 'border-rose-400' : 'border-gray-200 dark:border-gray-600' }}">
                            @if($convo['partner']->profile && $convo['partner']->profile->profile_photo)
                                <img src="{{ asset('storage/' . $convo['partner']->profile->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                </div>
                            @endif
                        </div>
                        @if($convo['partner']->profile && $convo['partner']->profile->last_active_at && $convo['partner']->profile->last_active_at->diffInMinutes(now()) < 30)
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white dark:border-gray-800"></div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-sm text-gray-800 dark:text-gray-100 {{ $convo['unread_count'] > 0 ? 'font-bold' : '' }}">{{ $convo['partner']->name }}</h3>
                            @if($convo['last_message'])
                                <span class="text-[11px] text-gray-400">{{ $convo['last_message']->created_at->diffForHumans(null, true) }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 truncate mt-0.5">
                            @if($convo['last_message'])
                                @if($convo['last_message']->sender_id === auth()->id())
                                    <span class="text-gray-300" data-en="You: " data-jp="あなた: ">You: </span>
                                @endif
                                {{ Str::limit($convo['last_message']->message, 50) }}
                            @else
                                <span class="italic" data-en="No messages yet — say hello!" data-jp="まだメッセージがありません。挨拶しましょう!">No messages yet — say hello!</span>
                            @endif
                        </p>
                    </div>

                    @if($convo['unread_count'] > 0)
                        <span class="bg-rose-500 text-white text-[11px] font-bold rounded-full w-5 h-5 flex items-center justify-center shrink-0">{{ $convo['unread_count'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-14 h-14 bg-violet-50 dark:bg-violet-900/15 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-violet-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-600 dark:text-gray-300 mb-1" data-en="No conversations yet" data-jp="まだ会話がありません">No conversations yet</h3>
            <p class="text-sm text-gray-400 mb-3" data-en="Match with someone to start chatting!" data-jp="マッチしてチャットを始めましょう!">Match with someone to start chatting!</p>
            <a href="{{ route('search') }}" class="btn btn-rose btn-sm" data-en="Browse Profiles" data-jp="プロフィールを見る">Browse Profiles</a>
        </div>
    @endif
</div>
@endsection
