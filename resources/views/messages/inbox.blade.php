@extends('layouts.app')
@section('title', 'Messages - KOKORO')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-extrabold mb-6">Messages</h1>

    @if(count($conversations) > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-50">
            @foreach($conversations as $convo)
                <a href="{{ route('messages.conversation', $convo['partner']->id) }}"
                   class="flex items-center gap-4 p-4 hover:bg-gray-50 transition {{ $convo['unread_count'] > 0 ? 'bg-pink-50/50' : '' }}">
                    {{-- Avatar --}}
                    <div class="relative shrink-0">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-pink-100 to-purple-100 overflow-hidden border-2 {{ $convo['unread_count'] > 0 ? 'border-primary' : 'border-gray-200' }}">
                            @if($convo['partner']->profile && $convo['partner']->profile->profile_photo)
                                <img src="{{ asset('storage/' . $convo['partner']->profile->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-pink-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                </div>
                            @endif
                        </div>
                        @if($convo['partner']->profile && $convo['partner']->profile->last_active_at && $convo['partner']->profile->last_active_at->diffInMinutes(now()) < 30)
                            <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-400 rounded-full border-2 border-white"></div>
                        @endif
                    </div>

                    {{-- Message preview --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-800 {{ $convo['unread_count'] > 0 ? 'font-bold' : '' }}">{{ $convo['partner']->name }}</h3>
                            @if($convo['last_message'])
                                <span class="text-xs text-gray-400">{{ $convo['last_message']->created_at->diffForHumans(null, true) }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-400 truncate mt-0.5">
                            @if($convo['last_message'])
                                @if($convo['last_message']->sender_id === auth()->id())
                                    <span class="text-gray-300">You: </span>
                                @endif
                                {{ Str::limit($convo['last_message']->message, 50) }}
                            @else
                                <span class="italic">No messages yet — say hello!</span>
                            @endif
                        </p>
                    </div>

                    {{-- Unread badge --}}
                    @if($convo['unread_count'] > 0)
                        <span class="bg-primary text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shrink-0">{{ $convo['unread_count'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-600 mb-2">No conversations yet</h3>
            <p class="text-gray-400 mb-4">Match with someone to start chatting!</p>
            <a href="{{ route('home') }}" class="inline-block btn-primary">Browse Profiles</a>
        </div>
    @endif
</div>
@endsection
