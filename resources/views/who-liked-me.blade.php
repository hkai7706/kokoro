@extends('layouts.app')
@section('title', 'Who Liked Me - KOKORO')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-extrabold mb-6 dark:text-gray-100" data-en="Who Liked Me" data-jp="誰がいいねしたか">Who Liked Me</h1>

    @if($likers->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($likers as $liker)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden card-hover animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.05 }}s">
                    <div class="relative h-60 bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-900/30 dark:to-purple-900/30">
                        @if($liker->profile && $liker->profile->profile_photo)
                            <img src="{{ asset('storage/' . $liker->profile->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-pink-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                        @endif
                        {{-- Mutual match badge --}}
                        @if(auth()->user()->isMatchedWith($liker->id))
                            <div class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow" data-en="Matched!" data-jp="マッチ!">Matched!</div>
                        @endif
                        {{-- Compatibility score --}}
                        @php $compat = auth()->user()->compatibilityWith($liker); @endphp
                        @if($compat > 0)
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2.5 py-1 rounded-full shadow {{ $compat >= 60 ? 'text-green-600' : ($compat >= 30 ? 'text-yellow-600' : 'text-gray-500') }}">
                                <span data-en="{{ $compat }}% match" data-jp="{{ $compat }}% 相性">{{ $compat }}% match</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ $liker->name }}@if($liker->profile), {{ $liker->profile->age }}@endif</h3>
                        @if($liker->profile)
                            <p class="text-sm text-gray-400 mb-1">
                                <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $liker->profile->location }}
                            </p>
                        @endif
                        <div class="flex gap-2 mt-3">
                            @if(!auth()->user()->hasLiked($liker->id))
                                <form method="POST" action="{{ route('match.like') }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $liker->id }}">
                                    <button type="submit" class="w-full btn-pink text-sm py-2">
                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                        <span data-en="Like Back" data-jp="いいね返し">Like Back</span>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('user.profile', $liker->id) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 font-medium py-2 rounded-full text-sm transition" data-en="View" data-jp="見る">View</a>
                            @if(auth()->user()->isMatchedWith($liker->id))
                                <a href="{{ route('messages.conversation', $liker->id) }}" class="flex-1 text-center btn-secondary text-sm py-2" data-en="Message" data-jp="メッセージ">Message</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $likers->links() }}</div>
    @else
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-pink-50 dark:bg-pink-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-600 dark:text-gray-300 mb-2" data-en="No one has liked you yet" data-jp="まだいいねされていません">No one has liked you yet</h3>
            <p class="text-gray-400" data-en="Keep your profile active and you'll get likes soon!" data-jp="プロフィールをアクティブにして、いいねをもらいましょう!">Keep your profile active and you'll get likes soon!</p>
            <a href="{{ route('search') }}" class="inline-block mt-4 btn-primary" data-en="Browse Profiles" data-jp="プロフィールを見る">Browse Profiles</a>
        </div>
    @endif
</div>
@endsection
