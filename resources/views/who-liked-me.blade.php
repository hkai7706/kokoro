@extends('layouts.app')
@section('title', 'Who Liked Me - KOKORO')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-5">
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100" data-en="People who liked you" data-jp="あなたにいいねした人">People who liked you</h1>
        <p class="text-sm text-gray-500 mt-0.5" data-en="Like them back to start a conversation" data-jp="いいね返しで会話が始まります">Like them back to start a conversation</p>
    </div>

    @if($likers->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($likers as $liker)
                <div class="card overflow-hidden animate-in" style="animation-delay:{{ $loop->index * 0.04 }}s">
                    <a href="{{ route('user.profile', $liker->id) }}" class="block">
                        <div class="relative h-48 bg-gray-100 dark:bg-gray-800">
                            @if($liker->profile && $liker->profile->profile_photo)
                                <img src="{{ asset('storage/' . $liker->profile->profile_photo) }}" class="w-full h-full object-cover" loading="lazy" alt="{{ $liker->name }}'s profile photo">
                            @else
                                <div class="w-full h-full flex items-center justify-center"><span class="text-4xl font-bold text-gray-200 dark:text-gray-700">{{ strtoupper(substr($liker->name, 0, 1)) }}</span></div>
                            @endif
                            @if(auth()->user()->isMatchedWith($liker->id))
                                <div class="absolute top-2.5 left-2.5 bg-emerald-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded" data-en="Matched" data-jp="マッチ">Matched</div>
                            @endif
                            @php $compat = auth()->user()->compatibilityWith($liker); @endphp
                            @if($compat > 0)
                                <div class="absolute top-2.5 right-2.5 bg-white/90 dark:bg-gray-900/90 backdrop-blur text-[11px] font-semibold px-2 py-0.5 rounded {{ $compat >= 60 ? 'text-emerald-600' : ($compat >= 30 ? 'text-amber-600' : 'text-gray-500') }}">{{ $compat }}%</div>
                            @endif
                        </div>
                    </a>
                    <div class="p-3.5">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $liker->name }}@if($liker->profile), {{ $liker->profile->age }}@endif</h3>
                        @if($liker->profile)<p class="text-[11px] text-gray-500 mt-0.5">{{ $liker->profile->location }}</p>@endif
                        <div class="flex gap-2 mt-3">
                            @if(!auth()->user()->hasLiked($liker->id))
                                <form method="POST" action="{{ route('match.like') }}" class="flex-1">@csrf<input type="hidden" name="user_id" value="{{ $liker->id }}"><button type="submit" class="w-full btn btn-rose btn-sm"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg><span data-en="Like back" data-jp="いいね返し">Like back</span></button></form>
                            @endif
                            <a href="{{ route('user.profile', $liker->id) }}" class="flex-1 btn btn-ghost btn-sm" data-en="View" data-jp="見る">View</a>
                            @if(auth()->user()->isMatchedWith($liker->id))
                                <a href="{{ route('messages.conversation', $liker->id) }}" class="flex-1 btn btn-outline btn-sm" data-en="Chat" data-jp="チャット">Chat</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $likers->links() }}</div>
    @else
        <div class="text-center py-20">
            <div class="w-12 h-12 bg-rose-50 dark:bg-rose-900/15 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-rose-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-600 dark:text-gray-300 text-sm mb-1" data-en="No likes yet" data-jp="まだいいねがありません">No likes yet</h3>
            <p class="text-xs text-gray-500 mb-4" data-en="Make sure your profile is complete — it helps you get noticed." data-jp="プロフィールを充実させると、注目されやすくなります。">Make sure your profile is complete — it helps you get noticed.</p>
            <a href="{{ route('profile.show') }}" class="btn btn-rose btn-sm" data-en="Update your profile" data-jp="プロフィールを更新">Update your profile</a>
        </div>
    @endif
</div>
@endsection
