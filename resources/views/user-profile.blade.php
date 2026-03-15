@extends('layouts.app')
@section('title', $user->name . ' - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 mb-4 transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        <span data-en="Back" data-jp="戻る">Back</span>
    </a>

    <div class="card overflow-hidden animate-in">
        {{-- Photo --}}
        <div class="h-72 bg-gray-100 dark:bg-gray-800 relative">
            @if($user->profile && $user->profile->profile_photo)
                <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
            @endif
            @if($isMatched)
                <div class="absolute top-3 left-3 bg-emerald-500 text-white text-xs font-semibold px-2.5 py-0.5 rounded-md" data-en="Matched" data-jp="マッチ">Matched</div>
            @endif
            @php $compat = auth()->user()->compatibilityWith($user); @endphp
            @if($compat > 0)
                <div class="absolute top-3 right-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur font-semibold px-2.5 py-0.5 rounded-md text-sm {{ $compat >= 60 ? 'text-emerald-600' : ($compat >= 30 ? 'text-amber-600' : 'text-gray-500') }}">
                    <span data-en="{{ $compat }}% compatible" data-jp="{{ $compat }}% 相性">{{ $compat }}% compatible</span>
                </div>
            @endif
        </div>

        <div class="p-6">
            <div class="flex items-center justify-between mb-3">
                <h1 class="text-xl font-bold dark:text-gray-100">
                    {{ $user->name }}
                    @if($user->profile)
                        <span class="text-gray-400 font-normal">, {{ $user->profile->age }}</span>
                    @endif
                </h1>
                {{-- More menu --}}
                <div class="relative">
                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    </button>
                    <div class="hidden absolute right-0 mt-1 w-44 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                        @if(auth()->user()->hasBlocked($user->id))
                            <form method="POST" action="{{ route('user.unblock') }}">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="block w-full text-left px-3.5 py-2 text-sm text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20" data-en="Unblock User" data-jp="ブロック解除">Unblock User</button></form>
                        @else
                            <form method="POST" action="{{ route('user.block') }}">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="block w-full text-left px-3.5 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20" onclick="return confirm('Block this user?')"><span data-en="Block User" data-jp="ブロック">Block User</span></button></form>
                        @endif
                        <button onclick="document.getElementById('report-modal').classList.remove('hidden')" class="block w-full text-left px-3.5 py-2 text-sm text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20">
                            <span data-en="Report User" data-jp="通報する">Report User</span>
                        </button>
                    </div>
                </div>
            </div>

            @if($user->profile)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    <svg class="w-3.5 h-3.5 inline -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $user->profile->location }}{{ $user->profile->prefecture ? ', ' . $user->profile->prefecture : '' }}
                    &middot; {{ ucfirst($user->profile->gender) }}
                </p>

                @if($user->profile->bio)
                    <div class="mb-5">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5" data-en="About" data-jp="自己紹介">About</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $user->profile->bio }}</p>
                    </div>
                @endif

                @if($user->profile->hobbies)
                    <div class="mb-4">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5" data-en="Hobbies" data-jp="趣味">Hobbies</h3>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($user->profile->hobbies_array as $hobby)
                                <span class="tag bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400">{{ $hobby }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($user->profile->interests)
                    <div class="mb-5">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5" data-en="Interests" data-jp="興味">Interests</h3>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($user->profile->interests_array as $interest)
                                <span class="tag bg-violet-50 dark:bg-violet-900/20 text-violet-600 dark:text-violet-400">{{ $interest }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($compat > 0)
                    <div class="mb-5 p-3.5 rounded-xl {{ $compat >= 60 ? 'bg-emerald-50 dark:bg-emerald-900/15 border border-emerald-100 dark:border-emerald-800/30' : ($compat >= 30 ? 'bg-amber-50 dark:bg-amber-900/15 border border-amber-100 dark:border-amber-800/30' : 'bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700') }}">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400" data-en="Compatibility Score" data-jp="相性スコア">Compatibility Score</h3>
                            <span class="text-sm font-bold {{ $compat >= 60 ? 'text-emerald-600' : ($compat >= 30 ? 'text-amber-600' : 'text-gray-500') }}">{{ $compat }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full transition-all {{ $compat >= 60 ? 'bg-emerald-500' : ($compat >= 30 ? 'bg-amber-500' : 'bg-gray-400') }}" style="width: {{ $compat }}%"></div>
                        </div>
                    </div>
                @endif
            @endif

            @if(!auth()->user()->hasBlocked($user->id))
                <div class="flex gap-2.5 pt-4 border-t border-gray-100 dark:border-gray-700">
                    @if(!$hasLiked)
                        <form method="POST" action="{{ route('match.like') }}" class="flex-1">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="w-full btn btn-rose"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg><span data-en="Like" data-jp="いいね">Like</span></button></form>
                    @else
                        <form method="POST" action="{{ route('match.unlike') }}" class="flex-1">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="w-full btn btn-outline text-red-500 border-red-200 hover:bg-red-50 dark:border-red-800 dark:hover:bg-red-900/20" data-en="Unlike" data-jp="いいね取消">Unlike</button></form>
                    @endif

                    @if($isMatched)
                        <a href="{{ route('messages.conversation', $user->id) }}" class="flex-1 btn btn-outline" data-en="Message" data-jp="メッセージ">Message</a>
                    @endif
                </div>
            @else
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 text-center">
                    <p class="text-gray-400 text-xs mb-2.5" data-en="You have blocked this user." data-jp="このユーザーをブロックしています。">You have blocked this user.</p>
                    <form method="POST" action="{{ route('user.unblock') }}">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="btn btn-outline btn-sm" data-en="Unblock" data-jp="ブロック解除">Unblock</button></form>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Report Modal --}}
<div id="report-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="document.getElementById('report-modal').classList.add('hidden')"></div>
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-5 animate-in">
        <h3 class="text-base font-bold text-gray-800 dark:text-gray-100 mb-3"><span data-en="Report {{ $user->name }}" data-jp="{{ $user->name }}を通報">Report {{ $user->name }}</span></h3>
        <form method="POST" action="{{ route('user.report') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Reason for report" data-jp="通報理由">Reason for report</label>
                <select name="reason" required class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400 mb-2.5">
                    <option value="" data-en="Select a reason..." data-jp="理由を選択...">Select a reason...</option>
                    <option value="Fake profile" data-en="Fake profile" data-jp="偽プロフィール">Fake profile</option>
                    <option value="Inappropriate content" data-en="Inappropriate content" data-jp="不適切なコンテンツ">Inappropriate content</option>
                    <option value="Harassment" data-en="Harassment" data-jp="嫌がらせ">Harassment</option>
                    <option value="Spam" data-en="Spam" data-jp="スパム">Spam</option>
                    <option value="Underage user" data-en="Underage user" data-jp="未成年ユーザー">Underage user</option>
                    <option value="Other" data-en="Other" data-jp="その他">Other</option>
                </select>
                <textarea name="details" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400" placeholder="Additional details (optional)..." data-placeholder-en="Additional details (optional)..." data-placeholder-jp="詳細（任意）..."></textarea>
            </div>
            <div class="flex gap-2.5">
                <button type="button" onclick="document.getElementById('report-modal').classList.add('hidden')" class="flex-1 btn btn-ghost" data-en="Cancel" data-jp="キャンセル">Cancel</button>
                <button type="submit" class="flex-1 btn bg-red-500 hover:bg-red-600 text-white" data-en="Submit Report" data-jp="通報を送信">Submit Report</button>
            </div>
        </form>
    </div>
</div>
@endsection
