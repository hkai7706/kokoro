@extends('layouts.app')
@section('title', 'Liked Profiles - KOKORO')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-extrabold mb-6 dark:text-gray-100" data-en="Liked Profiles" data-jp="いいねしたプロフィール">Liked Profiles</h1>

    @if($likedUsers->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($likedUsers as $likedUser)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden card-hover">
                    <div class="relative h-60 bg-gradient-to-br from-gray-800 to-gray-900">
                        @if($likedUser->profile && $likedUser->profile->profile_photo)
                            <img src="{{ asset('storage/' . $likedUser->profile->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                        @endif
                        {{-- Match indicator --}}
                        @if(auth()->user()->isMatchedWith($likedUser->id))
                            <div class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full" data-en="Matched!" data-jp="マッチ!">Matched!</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ $likedUser->name }}@if($likedUser->profile), {{ $likedUser->profile->age }}@endif</h3>
                        @if($likedUser->profile)
                            <p class="text-sm text-gray-400">{{ $likedUser->profile->location }}</p>
                        @endif
                        <div class="flex gap-2 mt-3">
                            <form method="POST" action="{{ route('match.unlike') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $likedUser->id }}">
                                <button type="submit" class="w-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-500 font-medium py-2 rounded-full text-sm transition" data-en="Unlike" data-jp="いいね取消">Unlike</button>
                            </form>
                            @if(auth()->user()->isMatchedWith($likedUser->id))
                                <a href="{{ route('messages.conversation', $likedUser->id) }}" class="flex-1 text-center btn-pink text-sm py-2" data-en="Message" data-jp="メッセージ">Message</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $likedUsers->links() }}</div>
    @else
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-pink-50 dark:bg-pink-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-600 dark:text-gray-300 mb-2" data-en="No likes yet" data-jp="まだいいねしていません">No likes yet</h3>
            <p class="text-gray-400" data-en="Start browsing profiles and like someone!" data-jp="プロフィールを見ていいねしましょう!">Start browsing profiles and like someone!</p>
            <a href="{{ route('search') }}" class="inline-block mt-4 btn-primary" data-en="Browse Profiles" data-jp="プロフィールを見る">Browse Profiles</a>
        </div>
    @endif
</div>
@endsection
