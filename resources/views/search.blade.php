@extends('layouts.app')
@section('title', 'Discover - KOKORO')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-5">
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100" data-en="Discover people" data-jp="人を探す">Discover people</h1>
        <p class="text-sm text-gray-400 mt-0.5" data-en="Find someone who shares your interests" data-jp="共通の趣味を持つ人を見つけましょう">Find someone who shares your interests</p>
    </div>

    {{-- Filters --}}
    <div class="card p-4 mb-6">
        <form method="GET" action="{{ route('search') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[140px]">
                <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Prefecture" data-jp="都道府県">Prefecture</label>
                <select name="prefecture" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                    <option value="" data-en="All" data-jp="すべて">All</option>
                    @foreach($prefectures as $pref)
                        <option value="{{ $pref }}" {{ request('prefecture') === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[120px]">
                <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Gender" data-jp="性別">Gender</label>
                <select name="gender" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                    <option value="" data-en="All" data-jp="すべて">All</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }} data-en="Male" data-jp="男性">Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }} data-en="Female" data-jp="女性">Female</option>
                    <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }} data-en="Other" data-jp="その他">Other</option>
                </select>
            </div>
            <div class="min-w-[80px]">
                <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Min Age" data-jp="最低年齢">Min Age</label>
                <input type="number" name="min_age" min="18" max="99" placeholder="18" value="{{ request('min_age') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
            </div>
            <div class="min-w-[80px]">
                <label class="block text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Max Age" data-jp="最高年齢">Max Age</label>
                <input type="number" name="max_age" min="18" max="99" placeholder="99" value="{{ request('max_age') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
            </div>
            <button type="submit" class="btn btn-rose" data-en="Search" data-jp="検索">Search</button>
            @if(request()->hasAny(['prefecture','gender','min_age','max_age']))
                <a href="{{ route('search') }}" class="text-xs text-gray-400 hover:text-gray-600 py-2" data-en="Clear filters" data-jp="フィルタークリア">Clear filters</a>
            @endif
        </form>
    </div>

    {{-- Results --}}
    @if($results->count() > 0)
        <p class="text-xs text-gray-400 mb-4"><span data-en="{{ $results->total() }} people found" data-jp="{{ $results->total() }}人が見つかりました">{{ $results->total() }} people found</span></p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($results as $userProfile)
                @php $compat = auth()->user()->compatibilityWith($userProfile); @endphp
                <div class="card overflow-hidden animate-in" style="animation-delay:{{ $loop->index * 0.04 }}s">
                    <a href="{{ route('user.profile', $userProfile->id) }}" class="block">
                        <div class="relative h-48 bg-gray-100 dark:bg-gray-800">
                            @if($userProfile->profile && $userProfile->profile->profile_photo)
                                <img src="{{ asset('storage/' . $userProfile->profile->profile_photo) }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-4xl font-bold text-gray-200 dark:text-gray-700">{{ strtoupper(substr($userProfile->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            @if($compat > 0)
                                <div class="absolute top-2.5 right-2.5 bg-white/90 dark:bg-gray-900/90 backdrop-blur text-[11px] font-semibold px-2 py-0.5 rounded {{ $compat >= 60 ? 'text-emerald-600' : ($compat >= 30 ? 'text-amber-600' : 'text-gray-500') }}">
                                    {{ $compat }}%
                                </div>
                            @endif
                            @if(auth()->user()->isMatchedWith($userProfile->id))
                                <div class="absolute top-2.5 left-2.5 bg-emerald-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded" data-en="Matched" data-jp="マッチ">Matched</div>
                            @endif
                        </div>
                    </a>
                    <div class="p-3.5">
                        <a href="{{ route('user.profile', $userProfile->id) }}">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $userProfile->name }}@if($userProfile->profile), {{ $userProfile->profile->age }}@endif</h3>
                            @if($userProfile->profile)
                                <p class="text-[11px] text-gray-400 mt-0.5">{{ $userProfile->profile->location }}</p>
                            @endif
                        </a>
                        @if($compat > 0)
                            <div class="mt-2">
                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1">
                                    <div class="h-1 rounded-full {{ $compat >= 60 ? 'bg-emerald-500' : ($compat >= 30 ? 'bg-amber-500' : 'bg-gray-300') }}" style="width:{{ $compat }}%"></div>
                                </div>
                            </div>
                        @endif
                        <div class="flex gap-2 mt-3">
                            @if(!auth()->user()->hasLiked($userProfile->id))
                                <form method="POST" action="{{ route('match.like') }}" class="flex-1">@csrf
                                    <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                                    <button type="submit" class="w-full btn btn-rose btn-sm" data-en="Like" data-jp="いいね">Like</button>
                                </form>
                            @else
                                <span class="flex-1 btn btn-ghost btn-sm text-rose-400 cursor-default" data-en="Liked" data-jp="いいね済">Liked</span>
                            @endif
                            <a href="{{ route('user.profile', $userProfile->id) }}" class="flex-1 btn btn-ghost btn-sm" data-en="View" data-jp="見る">View</a>
                            @if(auth()->user()->isMatchedWith($userProfile->id))
                                <a href="{{ route('messages.conversation', $userProfile->id) }}" class="btn btn-outline btn-sm" data-en="Chat" data-jp="チャット">Chat</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $results->withQueryString()->links() }}</div>
    @else
        <div class="text-center py-20">
            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-600 dark:text-gray-300 text-sm mb-1" data-en="No profiles found" data-jp="プロフィールが見つかりません">No profiles found</h3>
            <p class="text-xs text-gray-400" data-en="Try adjusting your filters or check back later" data-jp="フィルターを変更するか、後でまたチェックしてください">Try adjusting your filters or check back later</p>
        </div>
    @endif
</div>
@endsection
