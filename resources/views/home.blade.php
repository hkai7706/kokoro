@extends('layouts.app')
@section('title', 'Home - KOKORO')

@section('head')
<style>
    .game-card { transition: all 0.3s ease; cursor: pointer; }
    .game-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .stat-card { transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-2px); }
    .blog-card { transition: all 0.3s ease; }
    .blog-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .pulse-dot { animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    .quiz-option { transition: all 0.2s; }
    .quiz-option:hover { transform: scale(1.03); }
    .quiz-option.selected { border-color: #FF4D6D; background: #FFE4F0; }
    .fortune-card { perspective: 1000px; }
    .fortune-inner { transition: transform 0.6s; transform-style: preserve-3d; }
    .fortune-card.flipped .fortune-inner { transform: rotateY(180deg); }
    .fortune-front, .fortune-back { backface-visibility: hidden; }
    .fortune-back { transform: rotateY(180deg); }
    .emoji-grid button { transition: all 0.2s; }
    .emoji-grid button:hover { transform: scale(1.15); }
    .emoji-grid button.matched { opacity: 0.5; pointer-events: none; }
    .emoji-grid button.flip { animation: flipEmoji 0.3s ease; }
    @keyframes flipEmoji { 0% { transform: scale(1); } 50% { transform: scale(0.8) rotateY(90deg); } 100% { transform: scale(1); } }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-pink-500 via-rose-400 to-orange-400 dark:from-pink-700 dark:via-rose-600 dark:to-orange-600 rounded-3xl p-6 sm:p-8 mb-8 text-white relative overflow-hidden animate-fade-in-up">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-extrabold mb-2">
                <span data-en="Welcome back, {{ $user->name }}!" data-jp="おかえりなさい、{{ $user->name }}さん!">Welcome back, {{ $user->name }}!</span>
            </h1>
            <p class="text-white/80 text-sm sm:text-base" data-en="Here's what's happening on KOKORO today" data-jp="KOKOROの今日のアクティビティ">Here's what's happening on KOKORO today</p>
        </div>

        {{-- Stats Row --}}
        <div class="relative z-10 grid grid-cols-3 gap-3 sm:gap-4 mt-6">
            <a href="{{ route('search') }}" class="stat-card bg-white/20 backdrop-blur rounded-2xl p-3 sm:p-4 text-center hover:bg-white/30">
                <div class="text-2xl sm:text-3xl font-extrabold">{{ $matchCount }}</div>
                <div class="text-xs sm:text-sm text-white/80 font-medium" data-en="Matches" data-jp="マッチ">Matches</div>
            </a>
            <a href="{{ route('who.liked.me') }}" class="stat-card bg-white/20 backdrop-blur rounded-2xl p-3 sm:p-4 text-center hover:bg-white/30">
                <div class="text-2xl sm:text-3xl font-extrabold">{{ $likesReceived }}</div>
                <div class="text-xs sm:text-sm text-white/80 font-medium" data-en="Likes Received" data-jp="もらったいいね">Likes Received</div>
            </a>
            <a href="{{ route('messages.inbox') }}" class="stat-card bg-white/20 backdrop-blur rounded-2xl p-3 sm:p-4 text-center hover:bg-white/30">
                <div class="text-2xl sm:text-3xl font-extrabold">{{ $unreadMessages }}</div>
                <div class="text-xs sm:text-sm text-white/80 font-medium" data-en="Unread Messages" data-jp="未読メッセージ">Unread Messages</div>
            </a>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
        <a href="{{ route('search') }}" class="bg-white dark:bg-gray-800 rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700 card-hover">
            <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300" data-en="Find People" data-jp="人を探す">Find People</span>
        </a>
        <a href="{{ route('who.liked.me') }}" class="bg-white dark:bg-gray-800 rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700 card-hover">
            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300" data-en="Who Liked Me" data-jp="誰がいいね">Who Liked Me</span>
        </a>
        <a href="{{ route('messages.inbox') }}" class="bg-white dark:bg-gray-800 rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700 card-hover">
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300" data-en="Messages" data-jp="メッセージ">Messages</span>
        </a>
        <a href="{{ route('profile.show') }}" class="bg-white dark:bg-gray-800 rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700 card-hover">
            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300" data-en="My Profile" data-jp="プロフィール">My Profile</span>
        </a>
    </div>

    {{-- Mini Games Section --}}
    <div class="mb-8">
        <h2 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
            <span class="text-2xl">🎮</span>
            <span data-en="Mini Games & Fun" data-jp="ミニゲーム＆お楽しみ">Mini Games & Fun</span>
        </h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- Love Quiz --}}
            <div class="game-card bg-gradient-to-br from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 rounded-2xl p-5 border border-pink-100 dark:border-pink-800/30" onclick="startLoveQuiz()">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-pink-200 dark:bg-pink-800/50 rounded-xl flex items-center justify-center text-2xl">💕</div>
                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-gray-100" data-en="Love Quiz" data-jp="恋愛クイズ">Love Quiz</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400" data-en="Test your love knowledge!" data-jp="恋愛力をテスト!">Test your love knowledge!</p>
                    </div>
                </div>
                <div class="text-xs text-pink-500 dark:text-pink-400 font-semibold" data-en="▶ Play Now" data-jp="▶ プレイ">▶ Play Now</div>
            </div>

            {{-- Daily Fortune --}}
            <div class="game-card bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-2xl p-5 border border-purple-100 dark:border-purple-800/30" onclick="showFortune()">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-purple-200 dark:bg-purple-800/50 rounded-xl flex items-center justify-center text-2xl">🔮</div>
                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-gray-100" data-en="Today's Love Fortune" data-jp="今日の恋愛運">Today's Love Fortune</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400" data-en="What does fate say today?" data-jp="今日の運勢は?">What does fate say today?</p>
                    </div>
                </div>
                <div class="text-xs text-purple-500 dark:text-purple-400 font-semibold" data-en="▶ Reveal Fortune" data-jp="▶ 運勢を見る">▶ Reveal Fortune</div>
            </div>

            {{-- Emoji Match Game --}}
            <div class="game-card bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 rounded-2xl p-5 border border-yellow-100 dark:border-yellow-800/30" onclick="startEmojiMatch()">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-yellow-200 dark:bg-yellow-800/50 rounded-xl flex items-center justify-center text-2xl">🧩</div>
                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-gray-100" data-en="Emoji Match" data-jp="絵文字マッチ">Emoji Match</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400" data-en="Find the matching pairs!" data-jp="ペアを見つけよう!">Find the matching pairs!</p>
                    </div>
                </div>
                <div class="text-xs text-yellow-600 dark:text-yellow-400 font-semibold" data-en="▶ Play Now" data-jp="▶ プレイ">▶ Play Now</div>
            </div>
        </div>
    </div>

    {{-- Game Modal --}}
    <div id="game-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeGameModal()"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-lg p-6 sm:p-8 animate-fade-in-up max-h-[90vh] overflow-y-auto">
            <button onclick="closeGameModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div id="game-content"></div>
        </div>
    </div>

    {{-- Blog & Tips Section --}}
    <div class="mb-8">
        <h2 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
            <span class="text-2xl">📝</span>
            <span data-en="KOKORO Blog & Tips" data-jp="KOKOROブログ＆ヒント">KOKORO Blog & Tips</span>
        </h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="blog-card bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="h-36 bg-gradient-to-br from-rose-300 to-pink-400 flex items-center justify-center">
                    <span class="text-5xl">💌</span>
                </div>
                <div class="p-4">
                    <span class="text-xs text-pink-500 dark:text-pink-400 font-semibold uppercase" data-en="Dating Tips" data-jp="デートのコツ">Dating Tips</span>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mt-1 mb-2 text-sm" data-en="5 Tips for a Great First Message" data-jp="最初のメッセージを成功させる5つのコツ">5 Tips for a Great First Message</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2" data-en="Making a great first impression is key. Learn how to craft the perfect opening message that gets replies." data-jp="第一印象が大切です。返信がもらえる完璧なメッセージの書き方を学びましょう。">Making a great first impression is key. Learn how to craft the perfect opening message that gets replies.</p>
                    <button onclick="openBlogPost(1)" class="mt-3 text-xs text-pink-500 dark:text-pink-400 font-semibold hover:text-pink-600 transition" data-en="Read More →" data-jp="続きを読む →">Read More →</button>
                </div>
            </div>

            <div class="blog-card bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="h-36 bg-gradient-to-br from-violet-300 to-purple-400 flex items-center justify-center">
                    <span class="text-5xl">🌸</span>
                </div>
                <div class="p-4">
                    <span class="text-xs text-purple-500 dark:text-purple-400 font-semibold uppercase" data-en="Relationship" data-jp="恋愛コラム">Relationship</span>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mt-1 mb-2 text-sm" data-en="Understanding Japanese Dating Culture" data-jp="日本のデート文化を理解する">Understanding Japanese Dating Culture</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2" data-en="Explore the unique aspects of dating in Japan, from kokuhaku confessions to seasonal date ideas." data-jp="告白の文化から季節のデートアイデアまで、日本のデートの魅力を探りましょう。">Explore the unique aspects of dating in Japan, from kokuhaku confessions to seasonal date ideas.</p>
                    <button onclick="openBlogPost(2)" class="mt-3 text-xs text-purple-500 dark:text-purple-400 font-semibold hover:text-purple-600 transition" data-en="Read More →" data-jp="続きを読む →">Read More →</button>
                </div>
            </div>

            <div class="blog-card bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="h-36 bg-gradient-to-br from-emerald-300 to-teal-400 flex items-center justify-center">
                    <span class="text-5xl">✨</span>
                </div>
                <div class="p-4">
                    <span class="text-xs text-emerald-500 dark:text-emerald-400 font-semibold uppercase" data-en="Self Growth" data-jp="自己成長">Self Growth</span>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mt-1 mb-2 text-sm" data-en="Building Confidence for Better Connections" data-jp="より良い出会いのために自信をつける">Building Confidence for Better Connections</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2" data-en="Confidence is attractive. Discover practical ways to boost your self-esteem and connect authentically." data-jp="自信は魅力的です。自己肯定感を高め、本物のつながりを築く方法を見つけましょう。">Confidence is attractive. Discover practical ways to boost your self-esteem and connect authentically.</p>
                    <button onclick="openBlogPost(3)" class="mt-3 text-xs text-emerald-500 dark:text-emerald-400 font-semibold hover:text-emerald-600 transition" data-en="Read More →" data-jp="続きを読む →">Read More →</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Blog Post Modal --}}
    <div id="blog-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeBlogModal()"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-2xl p-6 sm:p-8 animate-fade-in-up max-h-[90vh] overflow-y-auto">
            <button onclick="closeBlogModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div id="blog-content"></div>
        </div>
    </div>

    {{-- Suggested Profiles (compact) --}}
    @if($suggested->count() > 0)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <span class="text-2xl">💫</span>
                <span data-en="Suggested for You" data-jp="おすすめのお相手">Suggested for You</span>
            </h2>
            <a href="{{ route('search') }}" class="text-sm text-pink-500 hover:text-pink-600 font-semibold transition" data-en="See All →" data-jp="すべて見る →">See All →</a>
        </div>
        <div class="grid sm:grid-cols-3 gap-4">
            @foreach($suggested as $profile)
                @php $compat = auth()->user()->compatibilityWith($profile); @endphp
                <a href="{{ route('user.profile', $profile->id) }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-4 card-hover flex items-center gap-3">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-900/30 dark:to-purple-900/30 overflow-hidden shrink-0 border-2 border-pink-200 dark:border-pink-800">
                        @if($profile->profile && $profile->profile->profile_photo)
                            <img src="{{ asset('storage/' . $profile->profile->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-lg font-bold text-pink-400">{{ strtoupper(substr($profile->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-bold text-gray-800 dark:text-gray-100 text-sm truncate">{{ $profile->name }}@if($profile->profile), {{ $profile->profile->age }}@endif</h3>
                        @if($profile->profile && $profile->profile->prefecture)
                            <p class="text-xs text-gray-400 truncate">{{ $profile->profile->prefecture }}</p>
                        @endif
                        @if($compat > 0)
                            <div class="flex items-center gap-1 mt-1">
                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-1">
                                    <div class="h-1 rounded-full {{ $compat >= 60 ? 'bg-green-500' : ($compat >= 30 ? 'bg-yellow-500' : 'bg-gray-400') }}" style="width: {{ $compat }}%"></div>
                                </div>
                                <span class="text-xs font-semibold {{ $compat >= 60 ? 'text-green-500' : ($compat >= 30 ? 'text-yellow-500' : 'text-gray-400') }}">{{ $compat }}%</span>
                            </div>
                        @endif
                    </div>
                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Daily Inspiration --}}
    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-2xl p-6 border border-amber-100 dark:border-amber-800/30 mb-8">
        <div class="flex items-start gap-4">
            <div class="text-3xl">🌟</div>
            <div>
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-1" data-en="Daily Inspiration" data-jp="今日のひとこと">Daily Inspiration</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm italic" id="daily-quote"></p>
                <p class="text-xs text-gray-400 mt-2" id="daily-quote-author"></p>
            </div>
        </div>
    </div>

    {{-- News Ticker --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 mb-4">
        <h2 class="text-lg font-extrabold text-gray-800 dark:text-gray-100 mb-3 flex items-center gap-2">
            <span class="text-xl">📰</span>
            <span data-en="KOKORO News" data-jp="KOKOROニュース">KOKORO News</span>
        </h2>
        <div class="space-y-3">
            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                <div class="w-2 h-2 bg-green-400 rounded-full mt-1.5 shrink-0 pulse-dot"></div>
                <div>
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200" data-en="New Feature: Emoji Match Game" data-jp="新機能：絵文字マッチゲーム">New Feature: Emoji Match Game</p>
                    <p class="text-xs text-gray-400" data-en="Try our new matching puzzle game while you wait for replies!" data-jp="返信を待つ間に新しいマッチングパズルゲームを試してみよう!">Try our new matching puzzle game while you wait for replies!</p>
                </div>
                <span class="text-xs text-gray-400 shrink-0" data-en="Today" data-jp="今日">Today</span>
            </div>
            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 shrink-0"></div>
                <div>
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200" data-en="Profile Tips: Complete your profile for better matches" data-jp="プロフィールのコツ：プロフィールを完成させてより良いマッチを">Profile Tips: Complete your profile for better matches</p>
                    <p class="text-xs text-gray-400" data-en="Users with complete profiles receive 3x more likes on average." data-jp="プロフィールが完成しているユーザーは平均3倍のいいねをもらえます。">Users with complete profiles receive 3x more likes on average.</p>
                </div>
                <span class="text-xs text-gray-400 shrink-0" data-en="Yesterday" data-jp="昨日">Yesterday</span>
            </div>
            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                <div class="w-2 h-2 bg-purple-400 rounded-full mt-1.5 shrink-0"></div>
                <div>
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200" data-en="Spring Event: Cherry Blossom Season Specials" data-jp="春イベント：桜シーズンスペシャル">Spring Event: Cherry Blossom Season Specials</p>
                    <p class="text-xs text-gray-400" data-en="Join our special hanami-themed matching event this month!" data-jp="今月のお花見テーマのマッチングイベントに参加しよう!">Join our special hanami-themed matching event this month!</p>
                </div>
                <span class="text-xs text-gray-400 shrink-0" data-en="This week" data-jp="今週">This week</span>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
// ── Daily Quotes ──
const quotes = {
    en: [
        { text: "The best thing to hold onto in life is each other.", author: "Audrey Hepburn" },
        { text: "Love is composed of a single soul inhabiting two bodies.", author: "Aristotle" },
        { text: "Where there is love there is life.", author: "Mahatma Gandhi" },
        { text: "To love and be loved is to feel the sun from both sides.", author: "David Viscott" },
        { text: "The greatest thing you'll ever learn is just to love and be loved in return.", author: "Eden Ahbez" },
        { text: "Love recognizes no barriers.", author: "Maya Angelou" },
        { text: "In all the world, there is no heart for me like yours.", author: "Maya Angelou" },
    ],
    jp: [
        { text: "人生で一番大切なのは、お互いを持つことです。", author: "オードリー・ヘプバーン" },
        { text: "愛とは、二つの体に宿る一つの魂である。", author: "アリストテレス" },
        { text: "愛のあるところに人生がある。", author: "マハトマ・ガンジー" },
        { text: "愛し愛されることは、両側から太陽を感じることです。", author: "デヴィッド・ヴィスコット" },
        { text: "あなたが学ぶ最も素晴らしいことは、ただ愛し、愛されることです。", author: "エデン・アーベズ" },
        { text: "愛は障壁を認めません。", author: "マヤ・アンジェロウ" },
        { text: "世界中のどの心も、あなたの心ほど私に合うものはありません。", author: "マヤ・アンジェロウ" },
    ]
};

function setDailyQuote() {
    const lang = localStorage.getItem('kokoro-lang') || 'en';
    const dayIndex = new Date().getDay() % quotes[lang].length;
    const q = quotes[lang][dayIndex];
    document.getElementById('daily-quote').textContent = '"' + q.text + '"';
    document.getElementById('daily-quote-author').textContent = '— ' + q.author;
}
setDailyQuote();

// Re-run on language change
const origApplyLang = window.applyLanguage;
window.applyLanguage = function(lang) {
    if (origApplyLang) origApplyLang(lang);
    setDailyQuote();
};
window.applyLanguage(localStorage.getItem('kokoro-lang') || 'en');

// ── Game Modal ──
function closeGameModal() { document.getElementById('game-modal').classList.add('hidden'); }
function openGameModal(html) {
    document.getElementById('game-content').innerHTML = html;
    document.getElementById('game-modal').classList.remove('hidden');
}

// ── Love Quiz ──
const quizQuestions = {
    en: [
        { q: "What does 'kokuhaku' mean in Japanese dating culture?", options: ["A first date", "A love confession", "A wedding proposal", "A breakup"], answer: 1 },
        { q: "Which flower symbolizes love in Japan?", options: ["Sakura", "Red Rose", "Sunflower", "Lily"], answer: 0 },
        { q: "What is the ideal first date activity according to surveys?", options: ["Movie theater", "Coffee shop", "Amusement park", "Walk in the park"], answer: 1 },
        { q: "What does a high compatibility score on KOKORO indicate?", options: ["Same age", "Shared hobbies & interests", "Same location only", "Same gender"], answer: 1 },
        { q: "Which season is most popular for dating in Japan?", options: ["Summer (Fireworks)", "Autumn (Momiji)", "Spring (Hanami)", "Winter (Christmas)"], answer: 2 },
    ],
    jp: [
        { q: "日本のデート文化で「告白」とは何を意味しますか？", options: ["初デート", "愛の告白", "プロポーズ", "別れ"], answer: 1 },
        { q: "日本で愛を象徴する花はどれですか？", options: ["桜", "赤いバラ", "ひまわり", "ユリ"], answer: 0 },
        { q: "調査によると、理想的な初デートは？", options: ["映画館", "カフェ", "遊園地", "公園散歩"], answer: 1 },
        { q: "KOKOROの高い相性スコアは何を示しますか？", options: ["同じ年齢", "共通の趣味と興味", "同じ場所のみ", "同じ性別"], answer: 1 },
        { q: "日本でデートに最も人気がある季節は？", options: ["夏（花火）", "秋（紅葉）", "春（花見）", "冬（クリスマス）"], answer: 2 },
    ]
};
let quizState = { current: 0, score: 0, lang: 'en' };

function startLoveQuiz() {
    quizState = { current: 0, score: 0, lang: localStorage.getItem('kokoro-lang') || 'en' };
    showQuizQuestion();
}

function showQuizQuestion() {
    const lang = quizState.lang;
    const questions = quizQuestions[lang];
    if (quizState.current >= questions.length) {
        const total = questions.length;
        const pct = Math.round((quizState.score / total) * 100);
        const resultMsg = lang === 'en'
            ? (pct >= 80 ? "Amazing! You're a love expert! 💕" : pct >= 60 ? "Great job! You know your stuff! 🌸" : pct >= 40 ? "Not bad! Keep learning! 📚" : "Time to brush up on love! 💌")
            : (pct >= 80 ? "すごい！恋愛マスターです！💕" : pct >= 60 ? "よくできました！知識豊富ですね！🌸" : pct >= 40 ? "まあまあ！もっと学びましょう！📚" : "恋愛について勉強しましょう！💌");
        const titleResult = lang === 'en' ? 'Quiz Complete!' : 'クイズ完了！';
        const scoreLabel = lang === 'en' ? 'Your Score' : 'あなたのスコア';
        const playAgain = lang === 'en' ? 'Play Again' : 'もう一度';
        const close = lang === 'en' ? 'Close' : '閉じる';
        openGameModal(`
            <div class="text-center py-4">
                <div class="text-6xl mb-4">${pct >= 60 ? '🏆' : '💪'}</div>
                <h3 class="text-2xl font-extrabold text-gray-800 dark:text-gray-100 mb-2">${titleResult}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">${resultMsg}</p>
                <div class="bg-pink-50 dark:bg-pink-900/20 rounded-2xl p-6 mb-6">
                    <div class="text-4xl font-extrabold text-pink-500">${quizState.score}/${total}</div>
                    <p class="text-sm text-pink-400 mt-1">${scoreLabel}</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="startLoveQuiz()" class="flex-1 btn-primary py-3">${playAgain}</button>
                    <button onclick="closeGameModal()" class="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 font-semibold py-3 rounded-full transition">${close}</button>
                </div>
            </div>
        `);
        return;
    }
    const q = questions[quizState.current];
    const qNum = lang === 'en' ? `Question ${quizState.current + 1} of ${questions.length}` : `問題 ${quizState.current + 1} / ${questions.length}`;
    const title = lang === 'en' ? '💕 Love Quiz' : '💕 恋愛クイズ';
    let optionsHtml = q.options.map((opt, i) => `
        <button onclick="answerQuiz(${i})" class="quiz-option w-full text-left p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-pink-300 dark:hover:border-pink-500 text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">${opt}</button>
    `).join('');
    openGameModal(`
        <h3 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">${title}</h3>
        <p class="text-xs text-gray-400 mb-4">${qNum}</p>
        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5 mb-6">
            <div class="h-1.5 rounded-full bg-pink-500 transition-all" style="width: ${((quizState.current) / questions.length) * 100}%"></div>
        </div>
        <p class="text-gray-700 dark:text-gray-200 font-semibold mb-4">${q.q}</p>
        <div>${optionsHtml}</div>
    `);
}

function answerQuiz(idx) {
    const lang = quizState.lang;
    const q = quizQuestions[lang][quizState.current];
    if (idx === q.answer) quizState.score++;
    quizState.current++;
    showQuizQuestion();
}

// ── Daily Fortune ──
function showFortune() {
    const lang = localStorage.getItem('kokoro-lang') || 'en';
    const fortunes = {
        en: [
            { level: "Great Luck! 🌟", msg: "Love is in the air today. Don't be afraid to make the first move!", color: "text-pink-500" },
            { level: "Good Luck! ✨", msg: "A meaningful conversation awaits you. Open your heart to new connections.", color: "text-purple-500" },
            { level: "Small Luck! 🍀", msg: "Take it easy today. Good things come to those who wait.", color: "text-green-500" },
            { level: "Lucky Day! 💫", msg: "Your charm is at its peak! Today is perfect for updating your profile.", color: "text-yellow-600" },
            { level: "Super Luck! 💖", msg: "Someone special is thinking about you right now. Check your messages!", color: "text-red-500" },
        ],
        jp: [
            { level: "大吉！🌟", msg: "今日は恋の予感。勇気を出して最初の一歩を踏み出しましょう！", color: "text-pink-500" },
            { level: "中吉！✨", msg: "意味のある会話が待っています。新しい出会いに心を開いて。", color: "text-purple-500" },
            { level: "小吉！🍀", msg: "今日はのんびり。待つ者に良いことが訪れます。", color: "text-green-500" },
            { level: "吉！💫", msg: "あなたの魅力は最高潮！今日はプロフィールを更新するのに最適です。", color: "text-yellow-600" },
            { level: "超大吉！💖", msg: "今、誰かがあなたのことを思っています。メッセージをチェックして！", color: "text-red-500" },
        ]
    };
    const dayIdx = new Date().getDate() % fortunes[lang].length;
    const f = fortunes[lang][dayIdx];
    const title = lang === 'en' ? "Today's Love Fortune" : '今日の恋愛運';
    const close = lang === 'en' ? 'Close' : '閉じる';
    openGameModal(`
        <div class="text-center py-4">
            <div class="text-7xl mb-4">🔮</div>
            <h3 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-2">${title}</h3>
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-2xl p-6 my-6">
                <div class="text-2xl font-extrabold ${f.color} mb-3">${f.level}</div>
                <p class="text-gray-600 dark:text-gray-300">${f.msg}</p>
            </div>
            <button onclick="closeGameModal()" class="btn-primary py-3 px-8">${close}</button>
        </div>
    `);
}

// ── Emoji Match Game ──
let emojiState = { cards: [], flipped: [], matched: [], moves: 0, started: false };
const emojiSets = ['💕', '🌸', '🎀', '🌟', '💎', '🦋', '🌈', '🍰'];

function startEmojiMatch() {
    const emojis = [...emojiSets, ...emojiSets].sort(() => Math.random() - 0.5);
    emojiState = { cards: emojis, flipped: [], matched: [], moves: 0, started: true };
    renderEmojiGame();
}

function renderEmojiGame() {
    const lang = localStorage.getItem('kokoro-lang') || 'en';
    const title = lang === 'en' ? '🧩 Emoji Match' : '🧩 絵文字マッチ';
    const movesLabel = lang === 'en' ? 'Moves' : '手数';
    const pairsLabel = lang === 'en' ? 'Pairs' : 'ペア';
    let gridHtml = '<div class="emoji-grid grid grid-cols-4 gap-2 mb-4">';
    emojiState.cards.forEach((emoji, i) => {
        const isFlipped = emojiState.flipped.includes(i) || emojiState.matched.includes(i);
        const isMatched = emojiState.matched.includes(i);
        gridHtml += `<button onclick="flipEmoji(${i})" class="w-full aspect-square rounded-xl text-2xl sm:text-3xl border-2 ${isMatched ? 'border-green-300 bg-green-50 dark:bg-green-900/20 matched' : isFlipped ? 'border-pink-300 bg-pink-50 dark:bg-pink-900/20' : 'border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600'} transition flex items-center justify-center font-bold" ${isMatched ? 'disabled' : ''}>${isFlipped || isMatched ? emoji : '?'}</button>`;
    });
    gridHtml += '</div>';
    openGameModal(`
        <h3 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">${title}</h3>
        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
            <span>${movesLabel}: <strong class="text-gray-800 dark:text-gray-100">${emojiState.moves}</strong></span>
            <span>${pairsLabel}: <strong class="text-gray-800 dark:text-gray-100">${emojiState.matched.length / 2}/${emojiSets.length}</strong></span>
        </div>
        ${gridHtml}
    `);

    if (emojiState.matched.length === emojiState.cards.length) {
        const congrats = lang === 'en' ? 'You found all pairs!' : '全ペア発見！';
        const movesText = lang === 'en' ? `Completed in ${emojiState.moves} moves` : `${emojiState.moves}手でクリア`;
        const playAgain = lang === 'en' ? 'Play Again' : 'もう一度';
        setTimeout(() => {
            openGameModal(`
                <div class="text-center py-4">
                    <div class="text-6xl mb-4">🎉</div>
                    <h3 class="text-2xl font-extrabold text-gray-800 dark:text-gray-100 mb-2">${congrats}</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">${movesText}</p>
                    <div class="flex gap-3">
                        <button onclick="startEmojiMatch()" class="flex-1 btn-primary py-3">${playAgain}</button>
                        <button onclick="closeGameModal()" class="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 font-semibold py-3 rounded-full transition">${lang === 'en' ? 'Close' : '閉じる'}</button>
                    </div>
                </div>
            `);
        }, 600);
    }
}

function flipEmoji(idx) {
    if (!emojiState.started || emojiState.flipped.length >= 2 || emojiState.flipped.includes(idx) || emojiState.matched.includes(idx)) return;
    emojiState.flipped.push(idx);
    if (emojiState.flipped.length === 2) {
        emojiState.moves++;
        const [a, b] = emojiState.flipped;
        if (emojiState.cards[a] === emojiState.cards[b]) {
            emojiState.matched.push(a, b);
            emojiState.flipped = [];
            renderEmojiGame();
        } else {
            renderEmojiGame();
            setTimeout(() => { emojiState.flipped = []; renderEmojiGame(); }, 800);
        }
    } else {
        renderEmojiGame();
    }
}

// ── Blog Posts ──
const blogPosts = {
    en: {
        1: {
            title: "5 Tips for a Great First Message",
            category: "Dating Tips",
            emoji: "💌",
            content: `
                <p class="mb-4">Your first message sets the tone for everything that follows. Here are 5 proven tips to help you make a memorable first impression:</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">1. Be Specific</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Reference something from their profile. Instead of "Hi, how are you?", try mentioning a shared hobby or interest.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">2. Ask a Question</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Give them something easy to respond to. Open-ended questions work best.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">3. Keep It Light</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Your first message should be fun and easygoing. Save deep topics for later conversations.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">4. Show Your Personality</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Don't be generic. Let your unique character shine through your words.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">5. Be Respectful</h4>
                <p class="text-gray-600 dark:text-gray-300">Politeness goes a long way. A kind message will always stand out.</p>
            `
        },
        2: {
            title: "Understanding Japanese Dating Culture",
            category: "Relationship",
            emoji: "🌸",
            content: `
                <p class="mb-4">Dating culture in Japan has its own unique traditions and customs. Here's what you should know:</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Kokuhaku (Confession)</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">In Japan, relationships typically begin with a formal confession of feelings. This direct approach shows sincerity and respect.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Seasonal Dating</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Japanese couples enjoy seasonal activities: hanami in spring, fireworks in summer, fall foliage viewing, and Christmas illuminations in winter.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Gift-Giving Traditions</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Valentine's Day and White Day are major occasions. Women give chocolate on Feb 14, and men reciprocate on March 14.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Taking Things Slowly</h4>
                <p class="text-gray-600 dark:text-gray-300">Building trust and understanding is valued. Many couples take time to get to know each other before becoming more serious.</p>
            `
        },
        3: {
            title: "Building Confidence for Better Connections",
            category: "Self Growth",
            emoji: "✨",
            content: `
                <p class="mb-4">Confidence is one of the most attractive qualities. Here are practical ways to build yours:</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Practice Self-Care</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Taking care of yourself physically and mentally creates a strong foundation for confidence.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Set Small Goals</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Achieving small goals builds momentum. Start by sending one new message each day.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Embrace Your Uniqueness</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">What makes you different makes you interesting. Your unique qualities are your biggest strengths.</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Learn from Experiences</h4>
                <p class="text-gray-600 dark:text-gray-300">Every interaction is a learning opportunity. Don't fear rejection — it brings you closer to the right person.</p>
            `
        }
    },
    jp: {
        1: {
            title: "最初のメッセージを成功させる5つのコツ",
            category: "デートのコツ",
            emoji: "💌",
            content: `
                <p class="mb-4">最初のメッセージがすべての始まりです。印象的な第一歩を踏み出すための5つのコツをご紹介します：</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">1. 具体的に</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">相手のプロフィールから何かを参考にしましょう。「こんにちは」だけでなく、共通の趣味に触れてみて。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">2. 質問をする</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">返信しやすい質問をしましょう。オープンな質問が最も効果的です。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">3. 軽い雰囲気で</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">最初のメッセージは楽しく気軽に。深い話題は後の会話に取っておきましょう。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">4. 自分らしさを出す</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">テンプレートは避けましょう。あなたの個性を言葉で表現してください。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">5. 礼儀正しく</h4>
                <p class="text-gray-600 dark:text-gray-300">丁寧さは大切です。優しいメッセージは必ず目立ちます。</p>
            `
        },
        2: {
            title: "日本のデート文化を理解する",
            category: "恋愛コラム",
            emoji: "🌸",
            content: `
                <p class="mb-4">日本のデート文化には独特の伝統と習慣があります。知っておくべきことをご紹介します：</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">告白文化</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">日本では、交際は通常、正式な気持ちの告白から始まります。この直接的なアプローチは誠実さと敬意を示します。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">季節のデート</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">日本のカップルは季節の活動を楽しみます：春の花見、夏の花火、秋の紅葉、冬のイルミネーション。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">贈り物の伝統</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">バレンタインデーとホワイトデーは重要なイベント。2月14日に女性がチョコを贈り、3月14日に男性がお返しをします。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">ゆっくりと進める</h4>
                <p class="text-gray-600 dark:text-gray-300">信頼と理解を築くことが大切にされています。多くのカップルは、より真剣になる前にお互いを知る時間を取ります。</p>
            `
        },
        3: {
            title: "より良い出会いのために自信をつける",
            category: "自己成長",
            emoji: "✨",
            content: `
                <p class="mb-4">自信は最も魅力的な資質の一つです。自信を高める実践的な方法をご紹介します：</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">セルフケアを実践</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">心身のケアは自信の土台を作ります。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">小さな目標を設定</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">小さな目標の達成が勢いを生みます。まずは毎日1通のメッセージを送ることから始めましょう。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">自分の個性を受け入れる</h4>
                <p class="mb-4 text-gray-600 dark:text-gray-300">あなたを特別にしているものが、あなたを面白くしています。ユニークな性質が最大の強みです。</p>
                <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-2">経験から学ぶ</h4>
                <p class="text-gray-600 dark:text-gray-300">すべてのやり取りは学びの機会です。拒絶を恐れないで — それはあなたを正しい人に近づけます。</p>
            `
        }
    }
};

function openBlogPost(id) {
    const lang = localStorage.getItem('kokoro-lang') || 'en';
    const post = blogPosts[lang][id];
    const back = lang === 'en' ? '← Back' : '← 戻る';
    document.getElementById('blog-content').innerHTML = `
        <div class="mb-4">
            <span class="text-4xl">${post.emoji}</span>
        </div>
        <span class="text-xs text-pink-500 dark:text-pink-400 font-semibold uppercase">${post.category}</span>
        <h3 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mt-1 mb-4">${post.title}</h3>
        <div class="prose prose-sm dark:prose-invert max-w-none text-sm leading-relaxed">${post.content}</div>
        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
            <button onclick="closeBlogModal()" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 font-medium transition">${back}</button>
        </div>
    `;
    document.getElementById('blog-modal').classList.remove('hidden');
}
function closeBlogModal() { document.getElementById('blog-modal').classList.add('hidden'); }
</script>
@endsection
