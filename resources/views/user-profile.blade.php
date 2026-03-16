@extends('layouts.app')
@section('title', $user->name . ' - KOKORO')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ url()->previous() }}" class="inline-flex items-center text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 mb-4 transition">
        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        <span data-en="Back" data-jp="戻る">Back</span>
    </a>

    <div class="card overflow-hidden animate-in">
        {{-- Photo --}}
        <div class="h-64 sm:h-72 bg-gray-100 dark:bg-gray-800 relative">
            @if($user->profile && $user->profile->profile_photo)
                <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <span class="text-6xl font-bold text-gray-200 dark:text-gray-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
            @endif
            @if($isMatched)
                <div class="absolute top-3 left-3 bg-emerald-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded" data-en="Matched" data-jp="マッチ">Matched</div>
            @endif
            @php $compat = auth()->user()->compatibilityWith($user); @endphp
            @if($compat > 0)
                <div class="absolute top-3 right-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur text-[11px] font-semibold px-2 py-0.5 rounded {{ $compat >= 60 ? 'text-emerald-600' : ($compat >= 30 ? 'text-amber-600' : 'text-gray-500') }}">
                    {{ $compat }}%
                </div>
            @endif
        </div>

        <div class="p-5">
            {{-- Name + menu --}}
            <div class="flex items-start justify-between mb-1">
                <div>
                    <h1 class="text-lg font-bold dark:text-gray-100">
                        {{ $user->name }}@if($user->profile), {{ $user->profile->age }}@endif
                    </h1>
                    @if($user->profile)
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $user->profile->location }}{{ $user->profile->prefecture ? ', ' . $user->profile->prefecture : '' }}
                            &middot; {{ ucfirst($user->profile->gender) }}
                        </p>
                    @endif
                </div>
                <div class="relative">
                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    </button>
                    <div class="hidden absolute right-0 mt-1 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200/60 dark:border-gray-700 py-1 z-50">
                        @if(auth()->user()->hasBlocked($user->id))
                            <form method="POST" action="{{ route('user.unblock') }}">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="block w-full text-left px-3 py-1.5 text-xs text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20" data-en="Unblock" data-jp="ブロック解除">Unblock</button></form>
                        @else
                            <form method="POST" action="{{ route('user.block') }}">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="block w-full text-left px-3 py-1.5 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20" onclick="return confirm('Block this user?')"><span data-en="Block" data-jp="ブロック">Block</span></button></form>
                        @endif
                        <button onclick="document.getElementById('report-modal').classList.remove('hidden')" class="block w-full text-left px-3 py-1.5 text-xs text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20">
                            <span data-en="Report" data-jp="通報">Report</span>
                        </button>
                    </div>
                </div>
            </div>

            @if($user->profile)
                {{-- Bio --}}
                @if($user->profile->bio)
                    <div class="mt-4 mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $user->profile->bio }}</p>
                    </div>
                @endif

                {{-- Hobbies & Interests --}}
                @if($user->profile->hobbies || $user->profile->interests)
                    <div class="flex flex-col gap-3 mb-4">
                        @if($user->profile->hobbies)
                            <div>
                                <h3 class="text-[11px] font-medium text-gray-400 mb-1.5" data-en="Hobbies" data-jp="趣味">Hobbies</h3>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($user->profile->hobbies_array as $hobby)
                                        <span class="tag bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400">{{ $hobby }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($user->profile->interests)
                            <div>
                                <h3 class="text-[11px] font-medium text-gray-400 mb-1.5" data-en="Interests" data-jp="興味">Interests</h3>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($user->profile->interests_array as $interest)
                                        <span class="tag bg-violet-50 dark:bg-violet-900/20 text-violet-600 dark:text-violet-400">{{ $interest }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Compatibility --}}
                @if($compat > 0)
                    <div class="mb-4 p-3 rounded-lg {{ $compat >= 60 ? 'bg-emerald-50 dark:bg-emerald-900/15' : ($compat >= 30 ? 'bg-amber-50 dark:bg-amber-900/15' : 'bg-gray-50 dark:bg-gray-800') }}">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400" data-en="Compatibility" data-jp="相性">Compatibility</span>
                            <span class="text-sm font-bold {{ $compat >= 60 ? 'text-emerald-600' : ($compat >= 30 ? 'text-amber-600' : 'text-gray-500') }}">{{ $compat }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1">
                            <div class="h-1 rounded-full {{ $compat >= 60 ? 'bg-emerald-500' : ($compat >= 30 ? 'bg-amber-500' : 'bg-gray-400') }}" style="width: {{ $compat }}%"></div>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1.5" data-en="Based on shared hobbies, interests, and location" data-jp="共通の趣味・興味・地域から算出">Based on shared hobbies, interests, and location</p>
                    </div>
                @endif
            @endif

            {{-- Actions --}}
            @if(!auth()->user()->hasBlocked($user->id))
                <div class="flex gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                    @if(!$hasLiked)
                        <form method="POST" action="{{ route('match.like') }}" class="flex-1">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="w-full btn btn-rose"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg><span data-en="Like" data-jp="いいね">Like</span></button></form>
                    @else
                        <form method="POST" action="{{ route('match.unlike') }}" class="flex-1">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="w-full btn btn-ghost text-rose-400" data-en="Unlike" data-jp="取消">Unlike</button></form>
                    @endif

                    @if($isMatched)
                        <a href="{{ route('messages.conversation', $user->id) }}" class="flex-1 btn btn-outline" data-en="Message" data-jp="メッセージ">Message</a>
                    @endif
                </div>
                @if($isMatched)
                    <p class="text-[11px] text-emerald-500 text-center mt-2" data-en="You're matched! Send a message to get started." data-jp="マッチしました！メッセージを送ってみましょう。">You're matched! Send a message to get started.</p>
                @elseif($hasLiked)
                    <p class="text-[11px] text-gray-400 text-center mt-2" data-en="You've liked this person. Waiting for them to like you back." data-jp="いいね済み。相手のいいね返しを待っています。">You've liked this person. Waiting for them to like you back.</p>
                @endif
            @else
                <div class="pt-3 border-t border-gray-100 dark:border-gray-700 text-center">
                    <p class="text-gray-400 text-xs mb-2" data-en="You have blocked this user." data-jp="このユーザーをブロックしています。">You have blocked this user.</p>
                    <form method="POST" action="{{ route('user.unblock') }}">@csrf<input type="hidden" name="user_id" value="{{ $user->id }}"><button type="submit" class="btn btn-ghost btn-sm" data-en="Unblock" data-jp="ブロック解除">Unblock</button></form>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Report Modal --}}
<div id="report-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="document.getElementById('report-modal').classList.add('hidden')"></div>
    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-sm p-5 animate-in">
        <h3 class="text-sm font-bold text-gray-800 dark:text-gray-100 mb-3"><span data-en="Report {{ $user->name }}" data-jp="{{ $user->name }}を通報">Report {{ $user->name }}</span></h3>
        <form method="POST" action="{{ route('user.report') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="mb-4">
                <select name="reason" required class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400 mb-2">
                    <option value="" data-en="Select a reason" data-jp="理由を選択">Select a reason</option>
                    <option value="Fake profile" data-en="Fake profile" data-jp="偽プロフィール">Fake profile</option>
                    <option value="Inappropriate content" data-en="Inappropriate content" data-jp="不適切なコンテンツ">Inappropriate content</option>
                    <option value="Harassment" data-en="Harassment" data-jp="嫌がらせ">Harassment</option>
                    <option value="Spam" data-en="Spam" data-jp="スパム">Spam</option>
                    <option value="Underage user" data-en="Underage user" data-jp="未成年ユーザー">Underage user</option>
                    <option value="Other" data-en="Other" data-jp="その他">Other</option>
                </select>
                <textarea name="details" rows="2" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-100 focus:border-rose-400" placeholder="Details (optional)" data-placeholder-en="Details (optional)" data-placeholder-jp="詳細（任意）"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('report-modal').classList.add('hidden')" class="flex-1 btn btn-ghost btn-sm" data-en="Cancel" data-jp="キャンセル">Cancel</button>
                <button type="submit" class="flex-1 btn bg-red-500 hover:bg-red-600 text-white btn-sm" data-en="Report" data-jp="通報">Report</button>
            </div>
        </form>
    </div>
</div>
@endsection
