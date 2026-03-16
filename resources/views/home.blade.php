@extends('layouts.app')
@section('title', 'Home - KOKORO')

@section('head')
<style>
    /* Game card gradients */
    .game-card{position:relative;overflow:hidden;border-radius:.75rem;padding:1.25rem;cursor:pointer;transition:all .2s;border:none}
    .game-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px -5px rgba(0,0,0,.15)}
    .game-card:active{transform:scale(.97)}
    .game-card .play-badge{position:absolute;top:.625rem;right:.625rem;background:rgba(255,255,255,.25);backdrop-filter:blur(4px);font-size:.625rem;font-weight:700;letter-spacing:.05em;padding:.125rem .5rem;border-radius:9999px;color:#fff;text-transform:uppercase}
    .game-card-rose{background:linear-gradient(135deg,#e11d48,#ec4899)}
    .game-card-violet{background:linear-gradient(135deg,#7c3aed,#6366f1)}
    .game-card-amber{background:linear-gradient(135deg,#f59e0b,#f97316)}
    .game-card-emerald{background:linear-gradient(135deg,#10b981,#14b8a6)}
    .game-card .game-icon{font-size:1.75rem;animation:float 3s ease-in-out infinite;display:inline-block}
    .game-card-rose .game-icon{animation-delay:0s}
    .game-card-violet .game-icon{animation-delay:.5s}
    .game-card-amber .game-icon{animation-delay:1s}
    .game-card-emerald .game-icon{animation-delay:1.5s}

    @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
    @keyframes shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-4px)}75%{transform:translateX(4px)}}
    @keyframes popIn{0%{transform:scale(0);opacity:0}50%{transform:scale(1.15)}100%{transform:scale(1);opacity:1}}
    @keyframes fadeScale{0%{transform:scale(.8);opacity:0}100%{transform:scale(1);opacity:1}}
    @keyframes confetti-fall{0%{transform:translateY(-10px) rotate(0);opacity:1}100%{transform:translateY(120px) rotate(720deg);opacity:0}}
    @keyframes heartFloat{0%{transform:translateY(0) scale(1);opacity:.9}100%{transform:translateY(-400px) scale(.4);opacity:0}}
    @keyframes pulse-ring{0%{box-shadow:0 0 0 0 rgba(225,29,72,.4)}100%{box-shadow:0 0 0 12px rgba(225,29,72,0)}}

    .shake-anim{animation:shake .4s ease}
    .pop-in{animation:popIn .3s ease}

    /* Quiz option styling */
    .quiz-opt{transition:all .15s;border:2px solid transparent;border-radius:.625rem;padding:.75rem 1rem;cursor:pointer;font-size:.8125rem;display:flex;align-items:center;gap:.625rem}
    .quiz-opt:hover{transform:translateX(4px)}
    .quiz-opt-default{background:rgba(244,63,94,.06);border-color:rgba(244,63,94,.15);color:#9f1239}
    .quiz-opt-default:hover{border-color:#fda4af;background:rgba(244,63,94,.1)}
    .dark .quiz-opt-default{background:rgba(244,63,94,.08);border-color:rgba(244,63,94,.2);color:#fda4af}
    .quiz-opt-correct{background:#d1fae5!important;border-color:#34d399!important;color:#065f46!important}
    .dark .quiz-opt-correct{background:rgba(16,185,129,.15)!important;border-color:#34d399!important;color:#6ee7b7!important}
    .quiz-opt-wrong{background:#fee2e2!important;border-color:#f87171!important;color:#991b1b!important}
    .dark .quiz-opt-wrong{background:rgba(239,68,68,.15)!important;border-color:#f87171!important;color:#fca5a5!important}
    .quiz-opt .opt-letter{width:1.5rem;height:1.5rem;border-radius:50%;background:rgba(244,63,94,.12);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.6875rem;flex-shrink:0}

    /* Emoji match cards */
    .emoji-card{perspective:600px;cursor:pointer}
    .emoji-card-inner{position:relative;width:100%;height:100%;transition:transform .4s cubic-bezier(.4,0,.2,1);transform-style:preserve-3d}
    .emoji-card.flipped .emoji-card-inner{transform:rotateY(180deg)}
    .emoji-card-front,.emoji-card-back{position:absolute;inset:0;backface-visibility:hidden;display:flex;align-items:center;justify-content:center;border-radius:.5rem;font-size:1.375rem}
    .emoji-card-front{background:linear-gradient(135deg,#fda4af,#f472b6);color:#fff}
    .dark .emoji-card-front{background:linear-gradient(135deg,#9f1239,#be185d)}
    .emoji-card-back{transform:rotateY(180deg);background:#fff;border:1.5px solid #e5e7eb}
    .dark .emoji-card-back{background:#1f2937;border-color:#374151}
    .emoji-card.matched .emoji-card-inner{transform:rotateY(180deg)}
    .emoji-card.matched .emoji-card-back{border-color:#34d399;background:#ecfdf5;box-shadow:0 0 12px rgba(52,211,153,.25)}
    .dark .emoji-card.matched .emoji-card-back{background:rgba(16,185,129,.1);border-color:#059669}
    .emoji-card-front .q-mark{font-weight:800;font-size:1rem;opacity:.9}

    /* Heart catcher */
    .catch-area{position:relative;overflow:hidden;border-radius:0;touch-action:manipulation;user-select:none}
    .falling-heart{position:absolute;cursor:pointer;font-size:1.5rem;transition:none;user-select:none;z-index:2}
    .falling-heart:hover{transform:scale(1.1)}
    .catch-burst{position:absolute;pointer-events:none;font-weight:800;font-size:.875rem;color:#e11d48;animation:heartFloat 1s ease forwards;z-index:3}
    .combo-text{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) scale(0);font-size:1.5rem;font-weight:900;color:#e11d48;pointer-events:none;opacity:0;transition:all .3s;z-index:10}
    .combo-text.show{transform:translate(-50%,-50%) scale(1);opacity:1}

    /* Article cards */
    .article-card{overflow:hidden;border-radius:.75rem;transition:all .2s}
    .article-card:hover{transform:translateY(-1px);box-shadow:0 4px 15px -3px rgba(0,0,0,.1)}
    .article-banner{height:3rem;display:flex;align-items:center;padding:0 .75rem}
    .article-banner-rose{background:linear-gradient(135deg,#fff1f2,#fce7f3)}
    .article-banner-violet{background:linear-gradient(135deg,#f5f3ff,#ede9fe)}
    .article-banner-amber{background:linear-gradient(135deg,#fffbeb,#fef3c7)}
    .dark .article-banner-rose{background:linear-gradient(135deg,rgba(225,29,72,.1),rgba(219,39,119,.1))}
    .dark .article-banner-violet{background:linear-gradient(135deg,rgba(124,58,237,.1),rgba(99,102,241,.1))}
    .dark .article-banner-amber{background:linear-gradient(135deg,rgba(245,158,11,.1),rgba(249,115,22,.1))}

    /* Confetti */
    .confetti-container{position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:5}
    .confetti-piece{position:absolute;width:6px;height:6px;border-radius:1px;animation:confetti-fall 1.5s ease forwards}

    /* Star rating */
    .star-empty{color:#d1d5db}
    .star-filled{color:#f59e0b}
    .dark .star-empty{color:#4b5563}
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Greeting --}}
    <div class="animate-in">
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            <span data-en="Hey {{ $user->name }}," data-jp="{{ $user->name }}さん、">Hey {{ $user->name }},</span>
        </h1>
        <p class="text-sm text-gray-400 mt-0.5" data-en="here's what's happening today." data-jp="今日の状況です。">here's what's happening today.</p>
    </div>

    {{-- Contextual nudge based on user state --}}
    @if($matchCount === 0 && $likesReceived === 0)
        <div class="bg-rose-50 dark:bg-rose-900/10 border border-rose-200/40 dark:border-rose-800/30 rounded-xl p-5 animate-in" style="animation-delay:.05s">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100" data-en="Start discovering people" data-jp="人を探してみましょう">Start discovering people</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed" data-en="Browse profiles and like someone to create your first match." data-jp="プロフィールを見ていいねしましょう。">Browse profiles and like someone to create your first match.</p>
                    <a href="{{ route('search') }}" class="inline-flex items-center gap-1.5 mt-3 btn btn-rose btn-sm">
                        <span data-en="Browse profiles" data-jp="プロフィールを見る">Browse profiles</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @elseif($likesReceived > 0 && $matchCount === 0)
        <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200/40 dark:border-amber-800/30 rounded-xl p-5 animate-in" style="animation-delay:.05s">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                        <span data-en="{{ $likesReceived }} {{ $likesReceived === 1 ? 'person likes' : 'people like' }} you" data-jp="{{ $likesReceived }}人があなたにいいねしています">{{ $likesReceived }} {{ $likesReceived === 1 ? 'person likes' : 'people like' }} you</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" data-en="Like them back to create a match and start chatting." data-jp="いいね返しでマッチが成立します。">Like them back to create a match and start chatting.</p>
                    <a href="{{ route('who.liked.me') }}" class="inline-flex items-center gap-1.5 mt-3 btn btn-rose btn-sm">
                        <span data-en="See who liked you" data-jp="いいねした人を見る">See who liked you</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @elseif($unreadMessages > 0)
        <div class="bg-violet-50 dark:bg-violet-900/10 border border-violet-200/40 dark:border-violet-800/30 rounded-xl p-5 animate-in" style="animation-delay:.05s">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                        <span data-en="You have {{ $unreadMessages }} unread {{ $unreadMessages === 1 ? 'message' : 'messages' }}" data-jp="未読メッセージが{{ $unreadMessages }}件あります">You have {{ $unreadMessages }} unread {{ $unreadMessages === 1 ? 'message' : 'messages' }}</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" data-en="Don't keep them waiting!" data-jp="返信しましょう！">Don't keep them waiting!</p>
                    <a href="{{ route('messages.inbox') }}" class="inline-flex items-center gap-1.5 mt-3 btn btn-rose btn-sm">
                        <span data-en="Open messages" data-jp="メッセージを開く">Open messages</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Activity numbers --}}
    <div class="grid grid-cols-3 gap-3 animate-in" style="animation-delay:.1s">
        <a href="{{ route('search') }}" class="card p-4 text-center">
            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tabular-nums">{{ $matchCount }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5" data-en="Matches" data-jp="マッチ">Matches</div>
        </a>
        <a href="{{ route('who.liked.me') }}" class="card p-4 text-center">
            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tabular-nums">{{ $likesReceived }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5" data-en="Likes" data-jp="いいね">Likes</div>
        </a>
        <a href="{{ route('messages.inbox') }}" class="card p-4 text-center">
            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tabular-nums">{{ $unreadMessages }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5" data-en="Unread" data-jp="未読">Unread</div>
        </a>
    </div>

    <div class="grid lg:grid-cols-5 gap-6">
        {{-- Left: Suggested profiles --}}
        <div class="lg:col-span-3 space-y-6">
            @if($suggested->count() > 0)
            <div class="animate-in" style="animation-delay:.15s">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300" data-en="People you might like" data-jp="おすすめの人">People you might like</h2>
                    <a href="{{ route('search') }}" class="text-xs text-rose-500 hover:text-rose-600 font-medium" data-en="See all" data-jp="すべて見る">See all</a>
                </div>
                <div class="space-y-3">
                    @foreach($suggested as $profile)
                        @php $compat = auth()->user()->compatibilityWith($profile); @endphp
                        <a href="{{ route('user.profile', $profile->id) }}" class="card flex items-center gap-4 p-4 group">
                            <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0">
                                @if($profile->profile && $profile->profile->profile_photo)
                                    <img src="{{ asset('storage/' . $profile->profile->profile_photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><span class="text-base font-bold text-gray-300 dark:text-gray-600">{{ strtoupper(substr($profile->name, 0, 1)) }}</span></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $profile->name }}@if($profile->profile), {{ $profile->profile->age }}@endif</h3>
                                    @if($compat >= 60)
                                        <span class="tag bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400">{{ $compat }}%</span>
                                    @elseif($compat >= 30)
                                        <span class="tag bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">{{ $compat }}%</span>
                                    @endif
                                </div>
                                @if($profile->profile && $profile->profile->prefecture)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $profile->profile->prefecture }}@if($profile->profile->location) &middot; {{ $profile->profile->location }}@endif</p>
                                @endif
                            </div>
                            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0 group-hover:text-rose-400 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Mini Games --}}
            <div class="animate-in" style="animation-delay:.2s">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3" data-en="Play a game" data-jp="ゲームで遊ぶ">Play a game</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <button onclick="startLoveQuiz()" class="game-card game-card-rose text-left text-white">
                        <span class="play-badge" data-en="Play" data-jp="遊ぶ">Play</span>
                        <span class="game-icon">&#128149;</span>
                        <h3 class="text-xs font-bold mt-2" data-en="Love Quiz" data-jp="恋愛クイズ">Love Quiz</h3>
                        <p class="text-[10px] text-white/70 mt-0.5" data-en="5 questions" data-jp="5問">5 questions</p>
                    </button>
                    <button onclick="showFortune()" class="game-card game-card-violet text-left text-white">
                        <span class="play-badge" data-en="Play" data-jp="遊ぶ">Play</span>
                        <span class="game-icon">&#128302;</span>
                        <h3 class="text-xs font-bold mt-2" data-en="Fortune" data-jp="恋愛運">Fortune</h3>
                        <p class="text-[10px] text-white/70 mt-0.5" data-en="Daily luck" data-jp="今日の運勢">Daily luck</p>
                    </button>
                    <button onclick="startEmojiMatch()" class="game-card game-card-amber text-left text-white">
                        <span class="play-badge" data-en="Play" data-jp="遊ぶ">Play</span>
                        <span class="game-icon">&#129513;</span>
                        <h3 class="text-xs font-bold mt-2" data-en="Memory" data-jp="神経衰弱">Memory</h3>
                        <p class="text-[10px] text-white/70 mt-0.5" data-en="Find pairs" data-jp="ペアを探す">Find pairs</p>
                    </button>
                    <button onclick="startHeartCatcher()" class="game-card game-card-emerald text-left text-white">
                        <span class="play-badge" data-en="New!" data-jp="新！">New!</span>
                        <span class="game-icon">&#128155;</span>
                        <h3 class="text-xs font-bold mt-2" data-en="Catch" data-jp="キャッチ">Catch</h3>
                        <p class="text-[10px] text-white/70 mt-0.5" data-en="Tap hearts" data-jp="ハートをタップ">Tap hearts</p>
                    </button>
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="animate-in" style="animation-delay:.2s">
                <div class="card p-4">
                    <p class="text-sm text-gray-600 dark:text-gray-300 italic leading-relaxed" id="daily-quote"></p>
                    <p class="text-[11px] text-gray-400 mt-2" id="daily-quote-author"></p>
                </div>
            </div>

            <div class="animate-in" style="animation-delay:.25s">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3" data-en="Tips & articles" data-jp="ヒント＆記事">Tips & articles</h2>
                <div class="space-y-2.5">
                    <button onclick="openBlogPost(1)" class="article-card card w-full text-left overflow-hidden">
                        <div class="article-banner article-banner-rose">
                            <span class="text-lg">&#128140;</span>
                            <span class="ml-auto text-[10px] font-medium text-rose-400" data-en="2 min read" data-jp="2分で読める">2 min read</span>
                        </div>
                        <div class="p-3">
                            <span class="inline-block text-[10px] font-semibold text-rose-500 bg-rose-50 dark:bg-rose-900/20 px-1.5 py-0.5 rounded mb-1" data-en="Dating Tips" data-jp="デートのコツ">Dating Tips</span>
                            <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="5 Tips for a Great First Message" data-jp="最初のメッセージを成功させる5つのコツ">5 Tips for a Great First Message</h3>
                        </div>
                    </button>
                    <button onclick="openBlogPost(2)" class="article-card card w-full text-left overflow-hidden">
                        <div class="article-banner article-banner-violet">
                            <span class="text-lg">&#127800;</span>
                            <span class="ml-auto text-[10px] font-medium text-violet-400" data-en="3 min read" data-jp="3分で読める">3 min read</span>
                        </div>
                        <div class="p-3">
                            <span class="inline-block text-[10px] font-semibold text-violet-500 bg-violet-50 dark:bg-violet-900/20 px-1.5 py-0.5 rounded mb-1" data-en="Culture" data-jp="文化">Culture</span>
                            <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="Understanding Japanese Dating Culture" data-jp="日本のデート文化を理解する">Understanding Japanese Dating Culture</h3>
                        </div>
                    </button>
                    <button onclick="openBlogPost(3)" class="article-card card w-full text-left overflow-hidden">
                        <div class="article-banner article-banner-amber">
                            <span class="text-lg">&#10024;</span>
                            <span class="ml-auto text-[10px] font-medium text-amber-400" data-en="2 min read" data-jp="2分で読める">2 min read</span>
                        </div>
                        <div class="p-3">
                            <span class="inline-block text-[10px] font-semibold text-amber-600 bg-amber-50 dark:bg-amber-900/20 px-1.5 py-0.5 rounded mb-1" data-en="Growth" data-jp="成長">Growth</span>
                            <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="Building Confidence for Better Connections" data-jp="より良い出会いのために自信をつける">Building Confidence for Better Connections</h3>
                        </div>
                    </button>
                </div>
            </div>

            <div class="animate-in" style="animation-delay:.3s">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3" data-en="What's new" data-jp="お知らせ">What's new</h2>
                <div class="space-y-2.5 text-xs text-gray-500 dark:text-gray-400">
                    <div class="flex items-start gap-2.5">
                        <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full mt-1.5 shrink-0"></div>
                        <p data-en="New: Heart Catcher game is live!" data-jp="新機能：ハートキャッチゲーム公開中!">New: Heart Catcher game is live!</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mt-1.5 shrink-0"></div>
                        <p data-en="Complete profiles get 3x more likes" data-jp="完成したプロフィールは3倍のいいねを獲得">Complete profiles get 3x more likes</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-1.5 h-1.5 bg-violet-400 rounded-full mt-1.5 shrink-0"></div>
                        <p data-en="Spring matching event this month" data-jp="今月の春マッチングイベント開催中">Spring matching event this month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Game Modal --}}
<div id="game-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeGameModal()"></div>
    <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg p-0 animate-in max-h-[90vh] overflow-hidden border border-gray-200 dark:border-gray-800">
        <button onclick="closeGameModal()" class="absolute top-3 right-3 z-10 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 bg-white/80 dark:bg-gray-800/80 backdrop-blur rounded-full w-7 h-7 flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div id="game-content" class="overflow-y-auto max-h-[85vh]"></div>
    </div>
</div>

{{-- Blog Modal --}}
<div id="blog-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeBlogModal()"></div>
    <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl p-0 animate-in max-h-[90vh] overflow-hidden border border-gray-200 dark:border-gray-800">
        <button onclick="closeBlogModal()" class="absolute top-3 right-3 z-10 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 bg-white/80 dark:bg-gray-800/80 backdrop-blur rounded-full w-7 h-7 flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div id="blog-content" class="overflow-y-auto max-h-[85vh]"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// ═══════════════════════════════════════
// DAILY QUOTE
// ═══════════════════════════════════════
const quotes={en:[{text:"The best thing to hold onto in life is each other.",author:"Audrey Hepburn"},{text:"Love is composed of a single soul inhabiting two bodies.",author:"Aristotle"},{text:"Where there is love there is life.",author:"Mahatma Gandhi"},{text:"To love and be loved is to feel the sun from both sides.",author:"David Viscott"},{text:"The greatest thing you'll ever learn is just to love and be loved in return.",author:"Eden Ahbez"},{text:"Love recognizes no barriers.",author:"Maya Angelou"},{text:"In all the world, there is no heart for me like yours.",author:"Maya Angelou"}],jp:[{text:"人生で一番大切なのは、お互いを持つことです。",author:"オードリー・ヘプバーン"},{text:"愛とは、二つの体に宿る一つの魂である。",author:"アリストテレス"},{text:"愛のあるところに人生がある。",author:"マハトマ・ガンジー"},{text:"愛し愛されることは、両側から太陽を感じることです。",author:"デヴィッド・ヴィスコット"},{text:"あなたが学ぶ最も素晴らしいことは、ただ愛し、愛されることです。",author:"エデン・アーベズ"},{text:"愛は障壁を認めません。",author:"マヤ・アンジェロウ"},{text:"世界中のどの心も、あなたの心ほど私に合うものはありません。",author:"マヤ・アンジェロウ"}]};
function setDailyQuote(){const l=localStorage.getItem('kokoro-lang')||'en';const i=new Date().getDay()%quotes[l].length;const q=quotes[l][i];document.getElementById('daily-quote').textContent='\u201C'+q.text+'\u201D';document.getElementById('daily-quote-author').textContent='\u2014 '+q.author}
setDailyQuote();
const origApplyLang=window.applyLanguage;window.applyLanguage=function(l){if(origApplyLang)origApplyLang(l);setDailyQuote()};window.applyLanguage(localStorage.getItem('kokoro-lang')||'en');

// ═══════════════════════════════════════
// MODAL HELPERS
// ═══════════════════════════════════════
function closeGameModal(){catchState.active=false;if(catchState.interval)clearInterval(catchState.interval);if(catchState.spawnInterval)clearTimeout(catchState.spawnInterval);if(emojiState.interval)clearInterval(emojiState.interval);document.getElementById('game-modal').classList.add('hidden')}
function openGameModal(h){document.getElementById('game-content').innerHTML=h;document.getElementById('game-modal').classList.remove('hidden')}
function closeBlogModal(){document.getElementById('blog-modal').classList.add('hidden')}

function spawnConfetti(container){const colors=['#e11d48','#ec4899','#f59e0b','#10b981','#6366f1','#8b5cf6'];for(let i=0;i<30;i++){const p=document.createElement('div');p.className='confetti-piece';p.style.cssText=`left:${Math.random()*100}%;top:-10px;background:${colors[Math.floor(Math.random()*colors.length)]};animation-delay:${Math.random()*.8}s;animation-duration:${1+Math.random()}s;width:${4+Math.random()*4}px;height:${4+Math.random()*4}px;border-radius:${Math.random()>.5?'50%':'1px'}`;container.appendChild(p)}setTimeout(()=>container.innerHTML='',2500)}
function getStars(moves,pairs){const r=moves/pairs;return r<=2.2?3:r<=3?2:1}
function renderStars(c){let s='';for(let i=1;i<=3;i++)s+=`<span class="${i<=c?'star-filled':'star-empty'}" style="font-size:1.5rem">&#9733;</span>`;return s}

// ═══════════════════════════════════════
// LOVE QUIZ
// ═══════════════════════════════════════
const quizQuestions={en:[{q:"What does 'kokuhaku' mean in Japanese dating?",options:["A first date","A love confession","A wedding proposal","A breakup"],answer:1},{q:"Which flower symbolizes love in Japan?",options:["Sakura","Red Rose","Sunflower","Lily"],answer:0},{q:"Ideal first date activity according to surveys?",options:["Movie theater","Coffee shop","Amusement park","Walk in the park"],answer:1},{q:"What does a high KOKORO compatibility score mean?",options:["Same age","Shared hobbies & interests","Same location only","Same gender"],answer:1},{q:"Most popular dating season in Japan?",options:["Summer","Autumn","Spring","Winter"],answer:2}],jp:[{q:"日本のデート文化で「告白」とは？",options:["初デート","愛の告白","プロポーズ","別れ"],answer:1},{q:"日本で愛を象徴する花は？",options:["桜","赤いバラ","ひまわり","ユリ"],answer:0},{q:"理想的な初デートは？",options:["映画館","カフェ","遊園地","公園散歩"],answer:1},{q:"KOKOROの高い相性スコアは？",options:["同じ年齢","共通の趣味と興味","同じ場所のみ","同じ性別"],answer:1},{q:"日本でデートに人気の季節は？",options:["夏","秋","春","冬"],answer:2}]};
const letters=['A','B','C','D'];
let quizState={current:0,score:0,lang:'en',answered:false};

function startLoveQuiz(){quizState={current:0,score:0,lang:localStorage.getItem('kokoro-lang')||'en',answered:false};showQuizQuestion()}
function showQuizQuestion(){
    const l=quizState.lang,qs=quizQuestions[l];
    if(quizState.current>=qs.length){const t=qs.length,p=Math.round(quizState.score/t*100);const m=l==='en'?(p>=80?"Love expert!":p>=60?"Great job!":p>=40?"Not bad!":"Keep learning!"):(p>=80?"恋愛マスター！":p>=60?"よくできました！":p>=40?"まあまあ！":"もっと学びましょう！");const emoji=p>=80?'&#127942;':p>=60?'&#127881;':p>=40?'&#128170;':'&#128218;';
    openGameModal(`<div class="relative"><div class="confetti-container" id="quiz-confetti"></div><div class="bg-gradient-to-b from-rose-500 to-pink-500 p-6 text-center text-white"><div class="text-3xl mb-2">${emoji}</div><h3 class="text-lg font-bold">${l==='en'?'Quiz Complete!':'クイズ完了！'}</h3><p class="text-white/70 text-sm">${m}</p></div><div class="p-6 text-center"><div class="inline-flex items-center gap-1 bg-rose-50 dark:bg-rose-900/15 rounded-full px-5 py-3 mb-5"><span class="text-2xl font-black text-rose-500 tabular-nums">${quizState.score}</span><span class="text-sm text-rose-300">/ ${t}</span></div><div class="flex gap-2"><button onclick="startLoveQuiz()" class="flex-1 btn btn-rose">${l==='en'?'Play Again':'もう一度'}</button><button onclick="closeGameModal()" class="flex-1 btn btn-ghost">${l==='en'?'Close':'閉じる'}</button></div></div></div>`);
    if(p>=60)setTimeout(()=>{const c=document.getElementById('quiz-confetti');if(c)spawnConfetti(c)},200);return}
    const q=qs[quizState.current];const dots=qs.map((_,i)=>`<div class="w-2 h-2 rounded-full ${i<quizState.current?'bg-rose-500':i===quizState.current?'bg-rose-400 animate-pulse':'bg-gray-200 dark:bg-gray-700'}"></div>`).join('');
    let opts=q.options.map((o,i)=>`<button onclick="answerQuiz(${i},this)" class="quiz-opt quiz-opt-default w-full text-left" id="quiz-opt-${i}"><span class="opt-letter">${letters[i]}</span><span>${o}</span></button>`).join('');
    openGameModal(`<div class="bg-gradient-to-b from-rose-500 to-pink-500 px-6 py-4 text-white"><h3 class="text-sm font-bold opacity-90">${l==='en'?'Love Quiz':'恋愛クイズ'}</h3><p class="text-[11px] text-white/60">${l==='en'?`Question ${quizState.current+1} of ${qs.length}`:`問題 ${quizState.current+1}/${qs.length}`}</p></div><div class="p-5"><div class="flex items-center justify-center gap-1.5 mb-4">${dots}</div><p class="text-gray-800 dark:text-gray-100 font-semibold mb-4 text-sm leading-relaxed">${q.q}</p><div class="space-y-2" id="quiz-options">${opts}</div></div>`);
    quizState.answered=false;
}
function answerQuiz(i,btn){if(quizState.answered)return;quizState.answered=true;const q=quizQuestions[quizState.lang][quizState.current];const correct=i===q.answer;if(correct)quizState.score++;document.getElementById('quiz-opt-'+q.answer).classList.remove('quiz-opt-default');document.getElementById('quiz-opt-'+q.answer).classList.add('quiz-opt-correct');if(!correct){btn.classList.remove('quiz-opt-default');btn.classList.add('quiz-opt-wrong','shake-anim')}document.querySelectorAll('#quiz-options button').forEach(b=>b.style.pointerEvents='none');setTimeout(()=>{quizState.current++;showQuizQuestion()},correct?600:1000)}

// ═══════════════════════════════════════
// LOVE FORTUNE
// ═══════════════════════════════════════
function showFortune(){const l=localStorage.getItem('kokoro-lang')||'en';const f={en:[{level:"Super Luck!",emoji:"&#10024;",msg:"Someone special is thinking about you right now!",gradient:"from-pink-500 to-rose-500"},{level:"Great Luck!",emoji:"&#128149;",msg:"Love is in the air today. Make the first move!",gradient:"from-rose-500 to-red-500"},{level:"Good Luck!",emoji:"&#127800;",msg:"A meaningful conversation awaits you today.",gradient:"from-violet-500 to-purple-500"},{level:"Small Luck!",emoji:"&#127808;",msg:"Good things come to those who wait patiently.",gradient:"from-emerald-500 to-teal-500"},{level:"Lucky Day!",emoji:"&#128171;",msg:"Your charm is at its peak! Update your profile.",gradient:"from-amber-500 to-orange-500"}],jp:[{level:"超大吉！",emoji:"&#10024;",msg:"誰かがあなたのことを思っています！",gradient:"from-pink-500 to-rose-500"},{level:"大吉！",emoji:"&#128149;",msg:"今日は恋の予感。最初の一歩を！",gradient:"from-rose-500 to-red-500"},{level:"中吉！",emoji:"&#127800;",msg:"意味のある会話が待っています。",gradient:"from-violet-500 to-purple-500"},{level:"小吉！",emoji:"&#127808;",msg:"待つ者に良いことが訪れます。",gradient:"from-emerald-500 to-teal-500"},{level:"吉！",emoji:"&#128171;",msg:"魅力は最高潮！プロフィールを更新しましょう。",gradient:"from-amber-500 to-orange-500"}]};const d=new Date().getDate()%f[l].length;const r=f[l][d];
openGameModal(`<div class="bg-gradient-to-b ${r.gradient} p-8 text-center text-white relative overflow-hidden"><div style="position:absolute;inset:0;background:radial-gradient(circle at 30% 20%,rgba(255,255,255,.15),transparent 50%),radial-gradient(circle at 70% 80%,rgba(255,255,255,.1),transparent 50%)"></div><div class="relative"><div class="text-4xl mb-3 pop-in">${r.emoji}</div><h3 class="text-2xl font-black mb-1">${r.level}</h3><p class="text-white/80 text-sm">${l==='en'?"Today's Love Fortune":"今日の恋愛運"}</p></div></div><div class="p-6 text-center"><p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-5 italic">"${r.msg}"</p><div class="flex gap-2"><a href="${'{{ route("search") }}'}" class="flex-1 btn btn-rose btn-sm">${l==='en'?'Browse Profiles':'プロフィールを見る'}</a><button onclick="closeGameModal()" class="flex-1 btn btn-ghost btn-sm">${l==='en'?'Close':'閉じる'}</button></div></div>`)}

// ═══════════════════════════════════════
// EMOJI MATCH
// ═══════════════════════════════════════
let emojiState={cards:[],flipped:[],matched:[],moves:0,started:false,timer:0,interval:null};
const emojiSets=['\u{1F495}','\u{1F338}','\u{1F380}','\u{1F31F}','\u{1F48E}','\u{1F98B}','\u{1F308}','\u{1F370}'];

function startEmojiMatch(){if(emojiState.interval)clearInterval(emojiState.interval);const e=[...emojiSets,...emojiSets].sort(()=>Math.random()-.5);emojiState={cards:e,flipped:[],matched:[],moves:0,started:true,timer:0,interval:null};emojiState.interval=setInterval(()=>{emojiState.timer++;updateEmojiTimer()},1000);renderEmojiGame()}
function updateEmojiTimer(){const el=document.getElementById('emoji-timer');if(el){const m=Math.floor(emojiState.timer/60);const s=emojiState.timer%60;el.textContent=(m>0?m+':':'')+s.toString().padStart(m>0?2:1,'0')}}
function renderEmojiGame(){const l=localStorage.getItem('kokoro-lang')||'en';let g='<div class="grid grid-cols-4 gap-2 mb-2">';emojiState.cards.forEach((e,i)=>{const isF=emojiState.flipped.includes(i),isM=emojiState.matched.includes(i);g+=`<div class="emoji-card ${isF||isM?'flipped':''} ${isM?'matched':''} aspect-square" onclick="flipEmoji(${i})"><div class="emoji-card-inner"><div class="emoji-card-front"><span class="q-mark">?</span></div><div class="emoji-card-back">${e}</div></div></div>`});g+='</div>';
openGameModal(`<div class="bg-gradient-to-b from-amber-500 to-orange-500 px-6 py-4 text-white"><h3 class="text-sm font-bold opacity-90">${l==='en'?'Emoji Match':'絵文字マッチ'}</h3><div class="flex gap-4 text-[11px] text-white/70 mt-0.5"><span>${l==='en'?'Moves':'手数'}: <strong class="text-white">${emojiState.moves}</strong></span><span>${l==='en'?'Pairs':'ペア'}: <strong class="text-white">${emojiState.matched.length/2}/${emojiSets.length}</strong></span><span class="ml-auto" id="emoji-timer">0</span></div></div><div class="p-4">${g}</div>`);updateEmojiTimer();
if(emojiState.matched.length===emojiState.cards.length){clearInterval(emojiState.interval);const stars=getStars(emojiState.moves,emojiSets.length);setTimeout(()=>{openGameModal(`<div class="relative"><div class="confetti-container" id="emoji-confetti"></div><div class="bg-gradient-to-b from-amber-500 to-orange-500 p-6 text-center text-white"><div class="text-3xl mb-2">&#127881;</div><h3 class="text-lg font-bold">${l==='en'?'All Pairs Found!':'全ペア発見！'}</h3></div><div class="p-6 text-center"><div class="mb-3">${renderStars(stars)}</div><div class="flex gap-4 justify-center text-xs text-gray-500 dark:text-gray-400 mb-5"><span>${l==='en'?'Moves':'手数'}: <strong class="text-gray-800 dark:text-gray-100">${emojiState.moves}</strong></span><span>${l==='en'?'Time':'時間'}: <strong class="text-gray-800 dark:text-gray-100">${Math.floor(emojiState.timer/60)}:${(emojiState.timer%60).toString().padStart(2,'0')}</strong></span></div><div class="flex gap-2"><button onclick="startEmojiMatch()" class="flex-1 btn btn-rose">${l==='en'?'Play Again':'もう一度'}</button><button onclick="closeGameModal()" class="flex-1 btn btn-ghost">${l==='en'?'Close':'閉じる'}</button></div></div></div>`);setTimeout(()=>{const c=document.getElementById('emoji-confetti');if(c)spawnConfetti(c)},200)},500)}}
function flipEmoji(i){if(!emojiState.started||emojiState.flipped.length>=2||emojiState.flipped.includes(i)||emojiState.matched.includes(i))return;emojiState.flipped.push(i);if(emojiState.flipped.length===2){emojiState.moves++;const[a,b]=emojiState.flipped;if(emojiState.cards[a]===emojiState.cards[b]){emojiState.matched.push(a,b);emojiState.flipped=[];renderEmojiGame()}else{renderEmojiGame();setTimeout(()=>{emojiState.flipped=[];renderEmojiGame()},700)}}else{renderEmojiGame()}}

// ═══════════════════════════════════════
// HEART CATCHER (Top Top Style Tap Game)
// ═══════════════════════════════════════
let catchState={score:0,combo:0,maxCombo:0,timeLeft:30,interval:null,spawnInterval:null,active:false};
const catchEmojis=['&#128149;','&#128150;','&#128151;','&#128152;','&#128155;','&#127800;','&#10024;','&#128142;'];
const catchBadEmojis=['&#128148;','&#128163;','&#9889;'];

function startHeartCatcher(){if(catchState.interval)clearInterval(catchState.interval);if(catchState.spawnInterval)clearTimeout(catchState.spawnInterval);catchState={score:0,combo:0,maxCombo:0,timeLeft:30,interval:null,spawnInterval:null,active:true};const l=localStorage.getItem('kokoro-lang')||'en';
openGameModal(`<div class="bg-gradient-to-b from-emerald-500 to-teal-500 px-6 py-4 text-white"><div class="flex items-center justify-between"><div><h3 class="text-sm font-bold opacity-90">${l==='en'?'Heart Catcher':'ハートキャッチ'}</h3><p class="text-[11px] text-white/60">${l==='en'?'Tap hearts to score!':'ハートをタップ！'}</p></div><div class="text-right"><div class="text-lg font-black tabular-nums" id="catch-score">0</div><div class="text-[10px] text-white/60" id="catch-combo"></div></div></div><div class="mt-2 w-full bg-white/20 rounded-full h-1.5"><div class="h-1.5 rounded-full bg-white transition-all" id="catch-timer-bar" style="width:100%"></div></div></div><div class="catch-area bg-gray-50 dark:bg-gray-800" id="catch-area" style="height:350px"><div class="combo-text" id="catch-combo-text"></div></div><div class="p-3 text-center"><p class="text-[11px] text-gray-400" id="catch-time-text">${l==='en'?'30s remaining':'残り30秒'}</p></div>`);
catchState.interval=setInterval(()=>{catchState.timeLeft--;const pct=(catchState.timeLeft/30)*100;const bar=document.getElementById('catch-timer-bar');const txt=document.getElementById('catch-time-text');if(bar)bar.style.width=pct+'%';if(txt)txt.textContent=(l==='en'?`${catchState.timeLeft}s remaining`:`残り${catchState.timeLeft}秒`);if(bar&&catchState.timeLeft<=10)bar.style.background='#f87171';if(catchState.timeLeft<=0)endHeartCatcher()},1000);
let spawnRate=800;function spawnLoop(){if(!catchState.active)return;spawnHeart();spawnRate=Math.max(300,spawnRate-15);catchState.spawnInterval=setTimeout(spawnLoop,spawnRate)}spawnLoop()}

function spawnHeart(){const area=document.getElementById('catch-area');if(!area||!catchState.active)return;const isBad=Math.random()<.15;const emoji=isBad?catchBadEmojis[Math.floor(Math.random()*catchBadEmojis.length)]:catchEmojis[Math.floor(Math.random()*catchEmojis.length)];const x=10+Math.random()*80;const speed=2+Math.random()*2.5;const size=1.25+Math.random()*.75;const heart=document.createElement('div');heart.className='falling-heart';heart.innerHTML=emoji;heart.style.cssText=`left:${x}%;top:-30px;font-size:${size}rem`;heart.dataset.bad=isBad?'1':'0';heart.dataset.points=isBad?'-5':(Math.random()<.1?'5':'1');let y=-30;
const fall=()=>{if(!catchState.active){heart.remove();return}y+=speed;heart.style.top=y+'px';if(y>360){heart.remove();if(!isBad&&catchState.active){catchState.combo=0;updateCombo()}return}requestAnimationFrame(fall)};
heart.addEventListener('click',e=>{e.stopPropagation();const pts=parseInt(heart.dataset.points);const bad=heart.dataset.bad==='1';if(bad){catchState.score=Math.max(0,catchState.score+pts);catchState.combo=0;showCatchBurst(heart,pts,true)}else{catchState.combo++;if(catchState.combo>catchState.maxCombo)catchState.maxCombo=catchState.combo;const mult=catchState.combo>=10?3:catchState.combo>=5?2:1;const fp=pts*mult;catchState.score+=fp;showCatchBurst(heart,fp,false);if(catchState.combo===5||catchState.combo===10)showComboText(catchState.combo)}updateCombo();const se=document.getElementById('catch-score');if(se){se.textContent=catchState.score;se.classList.add('pop-in');setTimeout(()=>se.classList.remove('pop-in'),300)}heart.remove()});
area.appendChild(heart);requestAnimationFrame(fall)}

function showCatchBurst(el,pts,bad){const area=document.getElementById('catch-area');if(!area)return;const b=document.createElement('div');b.className='catch-burst';b.style.left=el.style.left;b.style.top=el.style.top;b.style.color=bad?'#ef4444':'#e11d48';b.textContent=(pts>0?'+':'')+pts;area.appendChild(b);setTimeout(()=>b.remove(),1000)}
function showComboText(combo){const el=document.getElementById('catch-combo-text');if(!el)return;el.textContent=combo+'x COMBO!';el.classList.add('show');setTimeout(()=>el.classList.remove('show'),1000)}
function updateCombo(){const el=document.getElementById('catch-combo');if(el)el.textContent=catchState.combo>=3?catchState.combo+'x combo':''}

function endHeartCatcher(){catchState.active=false;if(catchState.interval)clearInterval(catchState.interval);if(catchState.spawnInterval)clearTimeout(catchState.spawnInterval);const l=localStorage.getItem('kokoro-lang')||'en';const s=catchState.score;const emoji=s>=80?'&#128081;':s>=50?'&#127775;':s>=20?'&#128170;':'&#128522;';const msg=l==='en'?(s>=80?'Incredible!':s>=50?'Great catch!':s>=20?'Nice try!':'Keep practicing!'):(s>=80?'すごい！':s>=50?'よくできました！':s>=20?'ナイストライ！':'練習あるのみ！');
setTimeout(()=>{openGameModal(`<div class="relative"><div class="confetti-container" id="catch-confetti"></div><div class="bg-gradient-to-b from-emerald-500 to-teal-500 p-6 text-center text-white"><div class="text-3xl mb-2">${emoji}</div><h3 class="text-lg font-bold">${l==='en'?"Time's Up!":"タイムアップ！"}</h3><p class="text-white/70 text-sm">${msg}</p></div><div class="p-6 text-center"><div class="inline-flex items-center gap-1 bg-emerald-50 dark:bg-emerald-900/15 rounded-full px-5 py-3 mb-2"><span class="text-2xl font-black text-emerald-500 tabular-nums">${s}</span><span class="text-sm text-emerald-300">${l==='en'?'pts':'点'}</span></div><p class="text-xs text-gray-400 mb-5">${l==='en'?'Max combo':'最大コンボ'}: ${catchState.maxCombo}x</p><div class="flex gap-2"><button onclick="startHeartCatcher()" class="flex-1 btn btn-rose">${l==='en'?'Play Again':'もう一度'}</button><button onclick="closeGameModal()" class="flex-1 btn btn-ghost">${l==='en'?'Close':'閉じる'}</button></div></div></div>`);if(s>=30)setTimeout(()=>{const c=document.getElementById('catch-confetti');if(c)spawnConfetti(c)},200)},300)}

// ═══════════════════════════════════════
// BLOG / ARTICLES
// ═══════════════════════════════════════
const blogPosts={en:{1:{title:"5 Tips for a Great First Message",cat:"Dating Tips",color:"rose",content:`<p class="mb-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">Your first message sets the tone for everything. Here are five tips that work:</p><div class="space-y-4"><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">1</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Be Specific</h4><p class="text-sm text-gray-500 dark:text-gray-400">Reference something from their profile. It shows you actually looked.</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">2</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Ask a Question</h4><p class="text-sm text-gray-500 dark:text-gray-400">Open-ended questions get the best responses.</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">3</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Keep It Light</h4><p class="text-sm text-gray-500 dark:text-gray-400">Be fun and easygoing. Save deep topics for later.</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">4</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Show Personality</h4><p class="text-sm text-gray-500 dark:text-gray-400">Let your unique character shine through.</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">5</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Be Respectful</h4><p class="text-sm text-gray-500 dark:text-gray-400">A kind, thoughtful message always stands out.</p></div></div></div>`},2:{title:"Understanding Japanese Dating Culture",cat:"Culture",color:"violet",content:`<p class="mb-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">Dating in Japan has unique traditions. Understanding them helps you connect better.</p><div class="space-y-3"><div class="p-3 bg-violet-50 dark:bg-violet-900/10 rounded-lg"><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">&#127800; Kokuhaku (Confession)</h4><p class="text-sm text-gray-500 dark:text-gray-400">Relationships begin with a formal confession of feelings.</p></div><div class="p-3 bg-violet-50 dark:bg-violet-900/10 rounded-lg"><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">&#127803; Seasonal Dating</h4><p class="text-sm text-gray-500 dark:text-gray-400">Couples enjoy hanami, fireworks, fall foliage, and Christmas lights.</p></div><div class="p-3 bg-violet-50 dark:bg-violet-900/10 rounded-lg"><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">&#127873; Gift-Giving</h4><p class="text-sm text-gray-500 dark:text-gray-400">Valentine's Day and White Day are major occasions for couples.</p></div><div class="p-3 bg-violet-50 dark:bg-violet-900/10 rounded-lg"><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">&#128156; Taking It Slow</h4><p class="text-sm text-gray-500 dark:text-gray-400">Building trust and understanding is highly valued.</p></div></div>`},3:{title:"Building Confidence for Better Connections",cat:"Self Growth",color:"amber",content:`<p class="mb-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">Confidence is one of the most attractive qualities. Build it naturally:</p><div class="space-y-4"><div class="flex gap-3"><div class="w-7 h-7 bg-amber-50 dark:bg-amber-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-amber-500 text-sm">&#128170;</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Practice Self-Care</h4><p class="text-sm text-gray-500 dark:text-gray-400">Taking care of yourself creates a strong foundation.</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-amber-50 dark:bg-amber-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-amber-500 text-sm">&#127919;</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Set Small Goals</h4><p class="text-sm text-gray-500 dark:text-gray-400">Start by sending one new message each day.</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-amber-50 dark:bg-amber-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-amber-500 text-sm">&#10024;</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Embrace Uniqueness</h4><p class="text-sm text-gray-500 dark:text-gray-400">Your unique qualities are your biggest strengths.</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-amber-50 dark:bg-amber-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-amber-500 text-sm">&#128214;</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">Learn from Experience</h4><p class="text-sm text-gray-500 dark:text-gray-400">Every interaction teaches you something new.</p></div></div></div>`}},jp:{1:{title:"最初のメッセージを成功させる5つのコツ",cat:"デートのコツ",color:"rose",content:`<p class="mb-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">最初のメッセージがすべての始まりです。効果的な5つのコツ：</p><div class="space-y-4"><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">1</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">具体的に</h4><p class="text-sm text-gray-500 dark:text-gray-400">プロフィールから話題を見つけましょう。</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">2</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">質問をする</h4><p class="text-sm text-gray-500 dark:text-gray-400">オープンな質問が返信率を上げます。</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">3</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">軽い雰囲気で</h4><p class="text-sm text-gray-500 dark:text-gray-400">最初は楽しく気軽に。</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">4</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">自分らしさを出す</h4><p class="text-sm text-gray-500 dark:text-gray-400">個性を言葉で表現しましょう。</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-rose-50 dark:bg-rose-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-rose-500 text-xs font-bold">5</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">礼儀正しく</h4><p class="text-sm text-gray-500 dark:text-gray-400">丁寧なメッセージは目立ちます。</p></div></div></div>`},2:{title:"日本のデート文化を理解する",cat:"文化",color:"violet",content:`<p class="mb-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">日本のデート文化の伝統を理解しましょう：</p><div class="space-y-3"><div class="p-3 bg-violet-50 dark:bg-violet-900/10 rounded-lg"><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">&#127800; 告白文化</h4><p class="text-sm text-gray-500 dark:text-gray-400">正式な気持ちの告白から交際が始まります。</p></div><div class="p-3 bg-violet-50 dark:bg-violet-900/10 rounded-lg"><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">&#127803; 季節のデート</h4><p class="text-sm text-gray-500 dark:text-gray-400">花見、花火、紅葉、イルミネーションを楽しみます。</p></div><div class="p-3 bg-violet-50 dark:bg-violet-900/10 rounded-lg"><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">&#127873; 贈り物</h4><p class="text-sm text-gray-500 dark:text-gray-400">バレンタインとホワイトデーは重要なイベントです。</p></div><div class="p-3 bg-violet-50 dark:bg-violet-900/10 rounded-lg"><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">&#128156; ゆっくりと</h4><p class="text-sm text-gray-500 dark:text-gray-400">信頼を築くことが大切です。</p></div></div>`},3:{title:"より良い出会いのために自信をつける",cat:"自己成長",color:"amber",content:`<p class="mb-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">自信は最も魅力的な資質です：</p><div class="space-y-4"><div class="flex gap-3"><div class="w-7 h-7 bg-amber-50 dark:bg-amber-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-amber-500 text-sm">&#128170;</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">セルフケア</h4><p class="text-sm text-gray-500 dark:text-gray-400">心身のケアは自信の土台です。</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-amber-50 dark:bg-amber-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-amber-500 text-sm">&#127919;</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">小さな目標</h4><p class="text-sm text-gray-500 dark:text-gray-400">毎日1通のメッセージから。</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-amber-50 dark:bg-amber-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-amber-500 text-sm">&#10024;</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">個性を受け入れる</h4><p class="text-sm text-gray-500 dark:text-gray-400">ユニークな性質が最大の強みです。</p></div></div><div class="flex gap-3"><div class="w-7 h-7 bg-amber-50 dark:bg-amber-900/15 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-amber-500 text-sm">&#128214;</span></div><div><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-0.5">経験から学ぶ</h4><p class="text-sm text-gray-500 dark:text-gray-400">すべてのやり取りから学べます。</p></div></div></div>`}}};
const blogGrad={rose:'from-rose-500 to-pink-500',violet:'from-violet-500 to-purple-500',amber:'from-amber-500 to-orange-500'};
const blogEmojis={1:'&#128140;',2:'&#127800;',3:'&#10024;'};
function openBlogPost(id){const l=localStorage.getItem('kokoro-lang')||'en';const p=blogPosts[l][id];document.getElementById('blog-content').innerHTML=`<div class="bg-gradient-to-b ${blogGrad[p.color]||'from-gray-500 to-gray-600'} px-6 py-5 text-white"><span class="text-2xl">${blogEmojis[id]||''}</span><span class="inline-block text-[10px] font-semibold bg-white/20 px-2 py-0.5 rounded-full ml-2">${p.cat}</span><h3 class="text-base font-bold mt-2">${p.title}</h3></div><div class="p-5">${p.content}</div><div class="px-5 pb-5"><button onclick="closeBlogModal()" class="btn btn-ghost btn-sm w-full">\u2190 ${l==='en'?'Back':'戻る'}</button></div>`;document.getElementById('blog-modal').classList.remove('hidden')}
</script>
@endsection
