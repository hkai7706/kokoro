@extends('layouts.app')
@section('title', 'Discover - KOKORO')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-5" data-en="Discover People" data-jp="人を探す">Discover People</h1>

    {{-- Filters --}}
    <div class="card p-4 mb-5">
        <form method="GET" action="{{ route('search') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Prefecture" data-jp="都道府県">Prefecture</label>
                <select name="prefecture" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                    <option value="" data-en="All" data-jp="すべて">All</option>
                    @foreach($prefectures as $pref)
                        <option value="{{ $pref }}" {{ request('prefecture') === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[120px]">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Gender" data-jp="性別">Gender</label>
                <select name="gender" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                    <option value="" data-en="All" data-jp="すべて">All</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }} data-en="Male" data-jp="男性">Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }} data-en="Female" data-jp="女性">Female</option>
                    <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }} data-en="Other" data-jp="その他">Other</option>
                </select>
            </div>
            <div class="min-w-[80px]">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Min Age" data-jp="最低年齢">Min Age</label>
                <input type="number" name="min_age" min="18" max="99" placeholder="18" value="{{ request('min_age') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
            </div>
            <div class="min-w-[80px]">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" data-en="Max Age" data-jp="最高年齢">Max Age</label>
                <input type="number" name="max_age" min="18" max="99" placeholder="99" value="{{ request('max_age') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
            </div>
            <button type="submit" class="btn btn-rose" data-en="Search" data-jp="検索">Search</button>
            @if(request()->hasAny(['prefecture','gender','min_age','max_age']))
                <a href="{{ route('search') }}" class="text-xs text-gray-400 hover:text-gray-600 py-2" data-en="Clear" data-jp="クリア">Clear</a>
            @endif
        </form>
    </div>

    {{-- Results --}}
    @if($results->count() > 0)
        <p class="text-xs text-gray-400 mb-4"><span data-en="{{ $results->total() }} found" data-jp="{{ $results->total() }}件">{{ $results->total() }} found</span></p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($results as $userProfile)
                @php $compat = auth()->user()->compatibilityWith($userProfile); @endphp
                <div class="card overflow-hidden">
                    <div class="relative h-52 bg-gray-100 dark:bg-gray-800">
                        @if($userProfile->profile && $userProfile->profile->profile_photo)
                            <img src="{{ asset('storage/' . $userProfile->profile->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                        @endif
                        @if($compat > 0)
                            <div class="absolute top-2.5 right-2.5 bg-white/90 dark:bg-gray-900/90 backdrop-blur text-xs font-semibold px-2 py-0.5 rounded-md {{ $compat >= 60 ? 'text-emerald-600' : ($compat >= 30 ? 'text-amber-600' : 'text-gray-500') }}">
                                {{ $compat }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-3.5">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $userProfile->name }}@if($userProfile->profile), {{ $userProfile->profile->age }}@endif</h3>
                        @if($userProfile->profile)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $userProfile->profile->location }}</p>
                        @endif
                        @if($compat > 0)
                            <div class="mt-2">
                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1">
                                    <div class="h-1 rounded-full {{ $compat >= 60 ? 'bg-emerald-500' : ($compat >= 30 ? 'bg-amber-500' : 'bg-gray-300') }}" style="width:{{ $compat }}%"></div>
                                </div>
                            </div>
                        @endif
                        <div class="flex gap-2 mt-3">
                            <form method="POST" action="{{ route('match.like') }}" class="flex-1">@csrf
                                <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                                <button type="submit" class="w-full btn btn-rose btn-sm" data-en="Like" data-jp="いいね">Like</button>
                            </form>
                            <a href="{{ route('user.profile', $userProfile->id) }}" class="flex-1 btn btn-ghost btn-sm" data-en="View" data-jp="見る">View</a>
                            @if(auth()->user()->isMatchedWith($userProfile->id))
                                <a href="{{ route('messages.conversation', $userProfile->id) }}" class="flex-1 btn btn-outline btn-sm" data-en="Chat" data-jp="チャット">Chat</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $results->withQueryString()->links() }}</div>
    @else
        <div class="text-center py-16">
            <div class="w-14 h-14 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-600 dark:text-gray-300 mb-1" data-en="No profiles found" data-jp="プロフィールが見つかりません">No profiles found</h3>
            <p class="text-sm text-gray-400" data-en="Try different filters" data-jp="別の条件を試してください">Try different filters</p>
        </div>
    @endif
</div>
@endsection
