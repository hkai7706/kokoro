@extends('layouts.app')
@section('title', 'Search by Area - KOKORO')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-extrabold mb-6 dark:text-gray-100" data-en="Search by Area" data-jp="エリア検索">Search by Area</h1>

    {{-- Search Filters --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5 mb-6 border border-gray-100 dark:border-gray-700">
        <form method="GET" action="{{ route('search') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1" data-en="Select Prefecture" data-jp="都道府県を選択">Select Prefecture</label>
                <select name="prefecture" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-primary focus:border-primary bg-kokoro-light-yellow dark:bg-gray-700">
                    <option value="" data-en="All prefectures" data-jp="すべての都道府県">All prefectures</option>
                    @foreach($prefectures as $pref)
                        <option value="{{ $pref }}" {{ request('prefecture') === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1" data-en="Select Gender" data-jp="性別を選択">Select Gender</label>
                <select name="gender" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-primary focus:border-primary bg-kokoro-light-pink dark:bg-gray-700">
                    <option value="" data-en="All genders" data-jp="すべての性別">All genders</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }} data-en="Male" data-jp="男性">Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }} data-en="Female" data-jp="女性">Female</option>
                    <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }} data-en="Other" data-jp="その他">Other</option>
                </select>
            </div>
            <div class="min-w-[100px]">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1" data-en="Min Age" data-jp="最低年齢">Min Age</label>
                <input type="number" name="min_age" min="18" max="99" placeholder="18"
                    value="{{ request('min_age') }}"
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-primary focus:border-primary">
            </div>
            <div class="min-w-[100px]">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1" data-en="Max Age" data-jp="最高年齢">Max Age</label>
                <input type="number" name="max_age" min="18" max="99" placeholder="99"
                    value="{{ request('max_age') }}"
                    class="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm focus:ring-primary focus:border-primary">
            </div>
            <button type="submit" class="px-8 py-2.5 bg-gray-800 hover:bg-gray-900 dark:bg-primary dark:hover:bg-primary-dark text-white font-semibold rounded-lg transition text-sm" data-en="Search" data-jp="検索">
                Search
            </button>
            @if(request()->hasAny(['prefecture', 'gender', 'min_age', 'max_age']))
                <a href="{{ route('search') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2" data-en="Clear" data-jp="クリア">Clear</a>
            @endif
        </form>
    </div>

    {{-- Results --}}
    @if($results->count() > 0)
        <p class="text-sm text-gray-400 mb-4"><span data-en="{{ $results->total() }} profiles found" data-jp="{{ $results->total() }}件のプロフィールが見つかりました">{{ $results->total() }} profiles found</span></p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($results as $userProfile)
                @php $compat = auth()->user()->compatibilityWith($userProfile); @endphp
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden card-hover">
                    <div class="relative h-60 bg-gradient-to-br from-gray-800 to-gray-900">
                        @if($userProfile->profile && $userProfile->profile->profile_photo)
                            <img src="{{ asset('storage/' . $userProfile->profile->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </div>
                        @endif
                        {{-- Compatibility badge --}}
                        @if($compat > 0)
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2.5 py-1 rounded-full shadow {{ $compat >= 60 ? 'text-green-600' : ($compat >= 30 ? 'text-yellow-600' : 'text-gray-500') }}">
                                <span data-en="{{ $compat }}% match" data-jp="{{ $compat }}% 相性">{{ $compat }}% match</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ $userProfile->name }}@if($userProfile->profile), {{ $userProfile->profile->age }}@endif</h3>
                        @if($userProfile->profile)
                            <p class="text-sm text-gray-400">{{ $userProfile->profile->location }}</p>
                        @endif
                        {{-- Compat bar --}}
                        @if($compat > 0)
                            <div class="mt-2 mb-1">
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $compat >= 60 ? 'bg-green-500' : ($compat >= 30 ? 'bg-yellow-500' : 'bg-gray-400') }}" style="width: {{ $compat }}%"></div>
                                </div>
                            </div>
                        @endif
                        <div class="flex gap-2 mt-3">
                            <form method="POST" action="{{ route('match.like') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                                <button type="submit" class="w-full btn-pink text-sm py-2" data-en="Like" data-jp="いいね">Like</button>
                            </form>
                            <a href="{{ route('user.profile', $userProfile->id) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 font-medium py-2 rounded-full text-sm transition" data-en="View" data-jp="見る">View</a>
                            @if(auth()->user()->isMatchedWith($userProfile->id))
                                <a href="{{ route('messages.conversation', $userProfile->id) }}" class="flex-1 text-center btn-secondary text-sm py-2" data-en="Message" data-jp="メッセージ">Message</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $results->withQueryString()->links() }}</div>
    @else
        <div class="text-center py-16">
            <h3 class="text-lg font-bold text-gray-600 dark:text-gray-300 mb-2" data-en="No profiles found" data-jp="プロフィールが見つかりません">No profiles found</h3>
            <p class="text-gray-400" data-en="Try different search filters" data-jp="別の検索条件を試してください">Try different search filters</p>
        </div>
    @endif
</div>
@endsection
