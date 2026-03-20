@extends('layouts.app')
@section('title', 'Messages - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100" data-en="Messages" data-jp="メッセージ">Messages</h1>
        @if(count($conversations) > 0)
            <p class="text-xs text-gray-500 mt-0.5" data-en="{{ count($conversations) }} conversation{{ count($conversations) !== 1 ? 's' : '' }}" data-jp="{{ count($conversations) }}件の会話">{{ count($conversations) }} conversation{{ count($conversations) !== 1 ? 's' : '' }}</p>
        @endif
    </div>

    @if(count($conversations) > 0)
        <div class="card divide-y divide-gray-100 dark:divide-gray-700/50 overflow-hidden">
            @foreach($conversations as $convo)
                <a href="{{ route('messages.conversation', $convo['partner']->id) }}"
                   class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition {{ $convo['unread_count'] > 0 ? 'bg-rose-50/30 dark:bg-rose-900/5' : '' }}">
                    {{-- Avatar --}}
                    <div class="relative shrink-0">
                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden {{ $convo['unread_count'] > 0 ? 'ring-2 ring-rose-400 ring-offset-1 dark:ring-offset-gray-900' : 'border border-gray-200 dark:border-gray-600' }}">
                            @if($convo['partner']->profile && $convo['partner']->profile->profile_photo)
                                <img src="{{ asset('storage/' . $convo['partner']->profile->profile_photo) }}" class="w-full h-full object-cover" loading="lazy" alt="{{ $convo['partner']->name }}'s profile photo">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-gray-300 dark:text-gray-500">{{ strtoupper(substr($convo['partner']->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        @if($convo['partner']->profile && $convo['partner']->profile->last_active_at && $convo['partner']->profile->last_active_at->diffInMinutes(now()) < 30)
                            <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-white dark:border-gray-900"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm text-gray-800 dark:text-gray-100 {{ $convo['unread_count'] > 0 ? 'font-bold' : 'font-medium' }}">{{ $convo['partner']->name }}</h3>
                            @if($convo['last_message'])
                                <span class="text-[11px] text-gray-300 dark:text-gray-500 shrink-0 ml-2">{{ $convo['last_message']->created_at->diffForHumans(null, true) }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 truncate mt-0.5">
                            @if($convo['last_message'])
                                @if($convo['last_message']->sender_id === auth()->id())
                                    <span class="text-gray-300 dark:text-gray-500" data-en="You: " data-jp="あなた: ">You: </span>
                                @endif
                                {{ Str::limit($convo['last_message']->message, 45) }}
                            @else
                                <span class="italic" data-en="No messages yet" data-jp="まだメッセージがありません">No messages yet</span>
                            @endif
                        </p>
                    </div>

                    {{-- Unread badge --}}
                    @if($convo['unread_count'] > 0)
                        <span class="bg-rose-500 text-white text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center shrink-0 px-1">{{ $convo['unread_count'] }}</span>
                    @else
                        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <div class="card text-center py-14 px-6">
            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1" data-en="No conversations yet" data-jp="まだ会話がありません">No conversations yet</h3>
            <p class="text-xs text-gray-500 mb-4 max-w-xs mx-auto" data-en="When you and someone both like each other, you'll be able to chat here." data-jp="お互いにいいねすると、ここでチャットできます。">When you and someone both like each other, you'll be able to chat here.</p>
            <a href="{{ route('search') }}" class="btn btn-rose btn-sm" data-en="Browse profiles" data-jp="プロフィールを見る">Browse profiles</a>
        </div>
    @endif
</div>
@endsection
