@extends('layouts.app')
@section('title', 'Liked Profiles - KOKORO')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-5">
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100" data-en="People you liked" data-jp="いいねした人">People you liked</h1>
        <p class="text-sm text-gray-400 mt-0.5" data-en="When they like you back, it's a match" data-jp="相手もいいねしてくれたらマッチ成立">When they like you back, it's a match</p>
    </div>

    @if($likedUsers->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($likedUsers as $likedUser)
                <div class="card overflow-hidden animate-in" style="animation-delay:{{ $loop->index * 0.04 }}s">
                    <a href="{{ route('user.profile', $likedUser->id) }}" class="block">
                        <div class="relative h-48 bg-gray-100 dark:bg-gray-800">
                            @if($likedUser->profile && $likedUser->profile->profile_photo)
                                <img src="{{ asset('storage/' . $likedUser->profile->profile_photo) }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center"><span class="text-4xl font-bold text-gray-200 dark:text-gray-700">{{ strtoupper(substr($likedUser->name, 0, 1)) }}</span></div>
                            @endif
                            @if(auth()->user()->isMatchedWith($likedUser->id))
                                <div class="absolute top-2.5 left-2.5 bg-emerald-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded" data-en="Matched" data-jp="マッチ">Matched</div>
                            @endif
                            @php $compat = auth()->user()->compatibilityWith($likedUser); @endphp
                            @if($compat > 0)
                                <div class="absolute top-2.5 right-2.5 bg-white/90 dark:bg-gray-900/90 backdrop-blur text-[11px] font-semibold px-2 py-0.5 rounded {{ $compat >= 60 ? 'text-emerald-600' : ($compat >= 30 ? 'text-amber-600' : 'text-gray-500') }}">{{ $compat }}%</div>
                            @endif
                        </div>
                    </a>
                    <div class="p-3.5">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $likedUser->name }}@if($likedUser->profile), {{ $likedUser->profile->age }}@endif</h3>
                        @if($likedUser->profile)<p class="text-[11px] text-gray-400 mt-0.5">{{ $likedUser->profile->location }}</p>@endif
                        <div class="flex gap-2 mt-3">
                            <form method="POST" action="{{ route('match.unlike') }}" class="flex-1">@csrf<input type="hidden" name="user_id" value="{{ $likedUser->id }}"><button type="submit" class="w-full btn btn-ghost btn-sm text-red-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20" data-en="Unlike" data-jp="取消">Unlike</button></form>
                            <a href="{{ route('user.profile', $likedUser->id) }}" class="flex-1 btn btn-ghost btn-sm" data-en="View" data-jp="見る">View</a>
                            @if(auth()->user()->isMatchedWith($likedUser->id))
                                <a href="{{ route('messages.conversation', $likedUser->id) }}" class="flex-1 btn btn-outline btn-sm" data-en="Chat" data-jp="チャット">Chat</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $likedUsers->links() }}</div>
    @else
        <div class="text-center py-20">
            <div class="w-12 h-12 bg-rose-50 dark:bg-rose-900/15 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-rose-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-600 dark:text-gray-300 text-sm mb-1" data-en="You haven't liked anyone yet" data-jp="まだ誰もいいねしていません">You haven't liked anyone yet</h3>
            <p class="text-xs text-gray-400 mb-4" data-en="Browse profiles and like people you're interested in." data-jp="プロフィールを見て気になる人にいいねしましょう。">Browse profiles and like people you're interested in.</p>
            <a href="{{ route('search') }}" class="btn btn-rose btn-sm" data-en="Browse profiles" data-jp="プロフィールを見る">Browse profiles</a>
        </div>
    @endif
</div>
@endsection
